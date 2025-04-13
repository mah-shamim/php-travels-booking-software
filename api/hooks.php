<?php

if (isset($hook)) {

    $uri = explode('/', $_SERVER['REQUEST_URI']);
    // Check if the HTTP_HOST value matches the string "localhost"
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        // Set the root variable to the concatenation of the protocol (http or https), the current HTTP_HOST value, and the first component of the REQUEST_URI array
        $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/' . $uri[1];
    } else {
        // Set the root variable to the concatenation of the protocol (http or https) and the current HTTP_HOST value
        $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    }

    // PUSHER
    $options = array('cluster' => 'us2', 'useTLS' => true);
    $pusher = new Pusher\Pusher('be4840bf63594e1468bb', '89406484859350dc3714', '1585424', $options);
    $channel = $_SERVER['SERVER_NAME'];

    // ==================================================================== LOGIN
    if ($hook == "login") {
        // SEND EMAIL IF USER ACTIVATED
        $title = "Login";
        $template = "login";
        $content = $_SERVER['REMOTE_ADDR'];
        $receiver_email = $user_data->email;
        $receiver_name = $user_data->first_name;
        //MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'User Login';
        $push_data['message2'] = 'User logged in with email ' . $user_data->email;
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== ACCOUNT ACTIVATION
    if ($hook == "account_activated") {

        // SEND EMAIL IF USER ACTIVATED
        $title = "Account Activated";
        $template = "account_activated";
        $content = "";
        $receiver_email = $user[0]['email'];
        $receiver_name = $user[0]['first_name'];
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Account';
        $push_data['message2'] = 'activated for user ' . $user[0]['email'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== PASSWORD RESET
    if ($hook == "forget_password") {

        // SEND EMAIL
        $title = "Forget Password";
        $template = "forget_password";
        $content = $newpass;
        $receiver_email = $user[0]['email'];
        $receiver_name = $user[0]['first_name'];
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Password';
        $push_data['message2'] = 'reset for account ' . $user[0]['email'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== USER SIGNUP
    if ($hook == "user_signup") {

        // SEND EMAIL FOR SIGNUP
        $title = "Signup";
        $template = "signup";
        $content = $link;
        $receiver_email = $_POST['email'];
        $receiver_name = $_POST['first_name'];
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Signup';
        $push_data['message2'] = 'account created for ' . $_POST['email'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== FLIGHTS BOOKING
    if ($hook == "flights_booking") {

        // SEND EMAIL
        $title = "Flight Booked";
        $template = "flights_booking";
        $content = $root . '/flights/invoice/' . $data->booking_ref_no;
        $receiver_email = ($data->email);
        $receiver_name = ($data->first_name) . ' ' . ($data->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Flight';
        $push_data['message2'] = 'booking invoice ' . $data->booking_ref_no;
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== FLIGHTS UPDATE BOOKING
    if ($hook == "flights_update_booking") {

        // SEND EMAIL
        $title = "Payment Completed";
        $template = "flights_booking";
        $content = $root . '/flights/invoice/' . $data[0]['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Flight';
        $push_data['message2'] = 'invoice updated ' . $data[0]['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== FLIGHTS CANCELLATION REQUEST
    if ($hook == "flights_cancellation_request") {

        // SEND EMAIL
        $title = "Cancellation Request";
        $template = "flights_cancellation";
        $content = $root . '/flights/invoice/' . $_POST['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Cancellation';
        $push_data['message2'] = 'flight Requested for invoice ' . $_POST['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }
    // ==================================================================== HOTELS BOOKING
    if ($hook == "hotels_booking") {

        // SEND EMAIL
        $title = "Hotel Booked";
        $template = "hotels_booking";
        $content = $root . '/hotels/invoice/' . $data->booking_ref_no;
        $receiver_email = ($data->email);
        $receiver_name = ($data->first_name) . ' ' . ($data->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Hotel';
        $push_data['message2'] = 'booking invoice ' . $data->booking_ref_no;
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== HOTELS UPDATE BOOKING
    if ($hook == "hotels/update_booking") {

        // SEND EMAIL
        $title = "Payment Completed";
        $template = "hotels_booking";
        $content = $root . '/hotels/invoice/' . $data[0]['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Hotel';
        $push_data['message2'] = 'invoice updated ' . $data[0]['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== HOTELS CANCELLATION REQUEST
    if ($hook == "hotels/cancellation_request") {

        // SEND EMAIL
        $title = "Cancellation Request";
        $template = "hotels_cancellation";
        $content = $root . '/hotels/invoice/' . $_POST['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Cancellation';
        $push_data['message2'] = 'hotel Requested for invoice ' . $_POST['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }
    // ==================================================================== TOURS BOOKING
    if ($hook == "tours_booking") {

        // SEND EMAIL
        $title = "Tour Booked";
        $template = "tours_booking";
        $content = $root . '/tours/invoice/' . $data->booking_ref_no;
        $receiver_email = ($data->email);
        $receiver_name = ($data->first_name) . ' ' . ($data->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Tour';
        $push_data['message2'] = 'booking invoice ' . $data->booking_ref_no;
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== TOURS UPDATE BOOKING
    if ($hook == "tours_update_booking") {

        // SEND EMAIL
        $title = "Payment Completed";
        $template = "tours_booking";
        $content = $root . '/tours/invoice/' . $data[0]['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Tour';
        $push_data['message2'] = 'invoice updated ' . $data[0]['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== TOURS CANCELLATION REQUEST
    if ($hook == "tours_cancellation_request") {

        // SEND EMAIL
        $title = "Cancellation Request";
        $template = "tours_cancellation";
        $content = $root . '/tours/invoice/' . $_POST['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Cancellation';
        $push_data['message2'] = 'tour Requested for invoice ' . $_POST['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }
     // ==================================================================== CARS BOOKING
     if ($hook == "cars_booking") {

        // SEND EMAIL
        $title = "cars Booked";
        $template = "cars_booking";
        $content = $root . '/cars/invoice/' . $data->booking_ref_no;
        $receiver_email = ($data->email);
        $receiver_name = ($data->first_name) . ' ' . ($data->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'car';
        $push_data['message2'] = 'booking invoice ' . $data->booking_ref_no;
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== CARS UPDATE BOOKING
    if ($hook == "cars_update_booking") {

        // SEND EMAIL
        $title = "Payment Completed";
        $template = "cars_booking";
        $content = $root . '/cars/invoice/' . $data[0]['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'car';
        $push_data['message2'] = 'invoice updated ' . $data[0]['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== CARS CANCELLATION REQUEST
    if ($hook == "cars_cancellation_request") {

        // SEND EMAIL
        $title = "Cancellation Request";
        $template = "cars_cancellation";
        $content = $root . '/cars/invoice/' . $_POST['booking_ref_no'];
        $receiver_email = ($user->email);
        $receiver_name = ($user->first_name) . ' ' . ($user->last_name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

        // PUSH NOTIFICATION
        $push_data['message1'] = 'Cancellation';
        $push_data['message2'] = 'car Requested for invoice ' . $_POST['booking_ref_no'];
        $pusher->trigger($channel, 'event', $push_data);

    }

    // ==================================================================== CARS CANCELLATION REQUEST
    if ($hook == "newsletter_subscribe") {

        // SEND EMAIL
        $title = "Newsletter Subscription";
        $template = "newsletter_subscription";
        $content = '';
        $receiver_email = ($email);
        $receiver_name = ($name);
        MAILER($template, $title, $content, $receiver_email, $receiver_name);

    }

}
?>