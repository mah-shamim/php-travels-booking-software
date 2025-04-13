<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Room_Calender extends MX_Controller
{
    public $limit = 3;
    public $hotel_id = 39;
    public $status = array("null","unpaid","cancelled","reserved","paid");

    public function __construct()
    {
        parent::__construct();
        $method_segment = $this->uri->segment(3);
        $this->role    = $this->session->userdata('pt_role');
        // If user is not log in then redirect the to admin panel.
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_id');
        if (empty($this->data['userloggedin']))
        {
            // Redirect user to admin/index (Admin Dashboard)
            $urisegment =  $this->uri->segment(1);
            $this->session->set_userdata('prevURL', current_url());
            redirect($urisegment);
        }
        // If user is admin then assign `admin` to segment otherwise `supplier`
        $administrator = $this->session->userdata('pt_logged_admin');
        if ( ! empty ($administrator))
        {
            $this->data['adminsegment'] = "admin";
        }
        else
        {
            $this->data['adminsegment'] = "supplier";
        }
        // Usecase 1: If someone make changes in session then this check can be helpful.
        // If segment string is `admin` then validate it otherwise validated `supplier`
        if ($this->data['adminsegment'] == "admin")
        {
            $checkpoint = modules :: run('Admin/validadmin');
            if ( ! $checkpoint) // If checkpoint become fail
            {
                redirect('admin');
            }
        }
        else
        {
            $checkpoint = modules :: run('supplier/validsupplier');
            if ( ! $checkpoint) // If checkpoint become fail
            {
                redirect('supplier');
            }
        }
        // Assign PHP Travel app settings, get it from settings table.
        $this->data['appSettings'] = modules :: run('Admin/appSettings');
        $this->data['addpermission'] = true;
        if($this->role == "supplier" || $this->role == "admin")
        {
            $this->editpermission = pt_permissions("edithotels", $this->data['userloggedin']);
            $this->deletepermission = pt_permissions("deletehotels", $this->data['userloggedin']);
            $this->data['addpermission'] = pt_permissions("addhotels", $this->data['userloggedin']);
        }
        $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
        $this->data['page_title'] = 'Room Calender';
    }

    public function index($hotel_slug = '')
    {
        $hotel = $this->Hotels_model->get_hotel_data($hotel_slug);
        $this->data['hotel_id'] = 0;
        $this->data['hotel_title'] = '';
        if (! empty($hotel) ) {
            $this->data['hotel_id'] = $hotel[0]->hotel_id;
            $this->data['hotel_title'] = $hotel[0]->hotel_title;
        }
        $this->data['apiUrl'] = base_url('admin/hotels/room_calender/');
        $this->data['main_content'] = 'calc/room_calender';
        $this->data['page_title'] = 'Room Calender';
        $this->data['header_title'] = 'Room Calender';
        $this->load->view('Admin/template', $this->data);
    }

    public function hotels()
    {
      $title = $this->input->get('q');
      if (! empty($title)) {
        $this->db->select('hotel_id as id, hotel_title as text');
        $this->db->like('hotel_title', $title);
        $dataAdapter = $this->db->get('pt_hotels');
        if ($dataAdapter->num_rows() > 0) {
          $dataset = $dataAdapter->result();
        }
      } else {
        $dataAdapter = $this->db->select('hotel_id as id, hotel_title as text')
        ->get('pt_hotels');
        $dataset = $dataAdapter->result();
      }
      $this->output->set_content_type('application/json');
      $data['results'] = $dataset;
      $this->output->set_output(json_encode($data));
    }

    public function data()
    {
        if (isset($_GET['editing']) && $_GET['editing'] == true) 
        {
            $this->onEventChanged();
        } 
        else 
        {
            $data = array(
                'data' => array(),
                'collections' => array(
                    'hour' => array(
                    [
                        "id" => "1",
                        "value" => "1",
                        "label" => "00:00"
                    ],
                    [
                        "id" => "2",
                        "value" => "2",
                        "label" => "59:59"
                    ]
                    ),
                    'priceRange' => array(
                    [
                        "id" => "1",
                        "value" => "1",
                        "label" => "Budget",
                        "minVal" => "50",
                        "maxVal" => "80",
                        "currency" => "PKR"
                    ],
                    [
                        "id" => "2",
                        "value" => "2",
                        "label" => "Premium",
                        "minVal" => "80",
                        "maxVal" => "120",
                        "currency" => "PKR"
                    ],
                    [
                        "id" => "3",
                        "value" => "3",
                        "label" => "Luxury",
                        "minVal" => "120",
                        "maxVal" => "150",
                        "currency" => "PKR"
                    ]
                    ),
                    'type' => array(),
                    'status' => array(
                        [
                        "id" => "1",
                        "value" => "1",
                        "label" => "unpaid"
                        ],
                        [
                        "id" => "2",
                        "value" => "2",
                        "label" => "cancelled"
                        ],
                        [
                        "id" => "3",
                        "value" => "3",
                        "label" => "reserved"
                        ],
                        [
                        "id" => "4",
                        "value" => "4",
                        "label" => "paid"
                        ]
                    ),
                    'room' => array(),
                )
            );
            $this->hotel_id = $this->input->get('hotel');
            $data['data'] = $this->bookings();
            $data['collections']['room'] = $this->rooms();
            $data['collections']['type'] = $this->room_types();
            if (!empty($_POST)) {
            $data = $_POST;
            }
            $this->output->set_output(json_encode($data));
        }
    }

    public function get_default_currency()
    {
        $this->db->where('is_active', 'Yes');
        return $this->db->get('pt_currencies')->row();
    }

    public function rooms()
    {
        $default_currency = $this->get_default_currency();
        $hotel_id = $this->hotel_id;
        $dataAdapter = $this->db->where('room_hotel', $hotel_id)->get('pt_rooms');
        $response = array();
        if ($dataAdapter->num_rows() > 0) {
            foreach ($dataAdapter->result() as $data) {
                array_push($response, array(
                    "id" => $data->room_id,
                    "value" => $data->room_id,
                    "label" => strlen($data->room_title) > 10 ? substr($data->room_title,0,15)."..." : $data->room_title,
                    "price" => round($default_currency->rate * $data->room_basic_price, 0),
                    "link" => base_url("uploads/images/hotels/rooms/thumbs/$data->thumbnail_image"),
                    "type" => $data->room_type,
                    "currency" => $default_currency->code
                ));
            }
        }
        return $response;
    }

    public function room_types()
    {
        $dataAdapter = $this->db->where('sett_type', 'rtypes')->limit($this->limit)->get('pt_hotels_types_settings');
        $response = array();
        if ($dataAdapter->num_rows() > 0) {
            foreach ($dataAdapter->result() as $data) {
                array_push($response, array(
                    "id" => $data->sett_id,
                    "value" => $data->sett_id,
                    "label" => $data->sett_name,
                ));
            }
        }
        return $response;
    }

    public function bookings()
    {
        $status = ['unpaid' => 1, 'cancelled' => 2, 'reserved' => 3, 'paid' => 4];

        $hotel = $this->db->select('hotel_title')->where('hotel_id', $this->hotel_id)->get('pt_hotels')->row();
        $dataAdapter = $this->db->select('pt_bookings.*, CONCAT(pt_accounts.ai_first_name, " ", pt_accounts.ai_last_name) AS username, pt_accounts.accounts_email')
        ->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id')
        ->where('booking_item', $this->hotel_id)
        ->where('booking_type', 'hotels')
        ->get('pt_bookings');
        $response = array();
        if ($dataAdapter->num_rows() > 0) {
            foreach ($dataAdapter->result() as $data) {
                $rooms = json_decode($data->booking_subitem);
                $rooms = (is_array($rooms))?$rooms:[$rooms];
                foreach ($rooms as $room) {
                    array_push($response, array(
                        "id" => $data->booking_id.'R'.$room->id,
                        "start_date" => $data->booking_checkin." 00:00",
                        "end_date" => $data->booking_checkout." 59:59",
                        "text" => $data->username,
                        "room" => $room->id,
                        "status" => (string)$status[$data->booking_status],
                        "email" => $data->accounts_email,
                        "hotel_name" => $hotel->hotel_title,
                        "invoice" => base_url("invoice?id=$data->booking_id&sessid=$data->booking_ref_no"),
                        "booking_total" => $data->booking_curr_code.' '.$data->booking_total
                    ));
                }
            }
        }
        return $response;
    }

    public function onEventChanged()
    {
        $action = 'error';
        $message = 'Booking Failed';
        $payload = $this->input->post();
        $booking_id = $this->input->post('ids');
        $_booking_id = explode('R', $booking_id)[0];
        $room = $this->input->post($booking_id.'_'.'room');
        $status = $this->input->post($booking_id.'_'.'status');
        $start_date = $this->input->post($booking_id.'_'.'start_date');
        $to_date = $this->input->post($booking_id.'_'.'end_date');
        $dataAdapter = $this->db->where('booking_id', $booking_id)->get('pt_bookings');
        if ($dataAdapter->num_rows() > 0) {
            $booking = $dataAdapter->row();
            $total_rooms_price = 0;
            $action = 'success';
            $message = 'Booking Updated';
            $booking_checkin = $start_date;
            $booking_checkout = $to_date;
            $total_stay = pt_count_days($booking_checkin, $booking_checkout);
            if (!empty($booking_checkin)) {
                $this->db->set('booking_checkin', $booking_checkin);
            }
            if (!empty($booking_checkout)) {
                $this->db->set('booking_checkout', $booking_checkout);
            }
            if (!empty($room)) {
                $rooms = json_decode($booking->booking_subitem);
                $rooms = is_array($rooms) ? $rooms : [$rooms];
                $currentRoomId = explode('R', $booking_id)[1];
                foreach ($rooms as &$_room) {
                    if ($_room->id == $currentRoomId) {
                        $_room->id = $room;
                    }
                    $total_rooms_price += $_room->price;
                }
                $this->db->set('booking_subitem', json_encode($rooms));
            }
            if (!empty($total_stay)) {
                $this->db->set('booking_nights', $total_stay);
                $booking_total = ($total_rooms_price * $total_stay);
                $this->load->library('Hotels_lib');
                // Comission and taxation
                $this->Hotels_lib->hotelid = $booking->booking_item;
                $policy = $this->Hotels_lib->hotel_tax_commision();
                $booking_deposit = $policy['commval'];
                $booking_tax = $policy['taxval'];
                if ($policy['commtype'] == 'percentage') {
                    $booking_deposit = ($booking_deposit * $booking_total) / 100;
                }
                if ($policy['taxtype'] == 'percentage') {
                    $booking_tax = ($booking_tax * $booking_total) / 100;
                }
                $this->db->set('booking_deposit', $booking_deposit);
                $this->db->set('booking_tax', $booking_tax);
                $booking_total = $booking_total + $booking_tax;
                $this->db->set('booking_total', $booking_total);
                $this->db->set('booking_remaining', $booking_total);
                $this->db->set('booking_amount_paid', 0);
            }
            $update_room_status = false;
            if (!empty($status)) {
                $update_room_status = true;
                $booking_status = $this->status[$status];
                if ($booking_status == 'paid') {
                    $this->db->set('booking_remaining', 0);
                    $this->db->set('booking_amount_paid', $booking_total);
                } else {
                    $this->db->set('booking_remaining', $booking_total);
                    $this->db->set('booking_amount_paid', 0);
                }
                $this->db->set('booking_status', $booking_status);
            }
            $this->db->where('booking_id', $_booking_id);
            $this->db->update('pt_bookings');

            if ($update_room_status)
            {
                $this->db->where('booked_booking_id', $_booking_id);
                $this->db->update('pt_booked_rooms', array(
                    'booked_booking_status' => $booking_status
                ));
            }
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'action' => $action,
            'message' => $message
        ]));
    }
}
