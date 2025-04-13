<?php

class Mapbuilder
{
    const MAP_TYPE_ID_HYBRID = 'HYBRID';
    const MAP_TYPE_ID_ROADMAP = 'ROADMAP';
    const MAP_TYPE_ID_SATELLITE = 'SATELLITE';
    const MAP_TYPE_ID_TERRAIN = 'TERRAIN';

    const CONTROL_POSITION_BOTTOM_CENTER = 'BOTTOM_CENTER';
    const CONTROL_POSITION_BOTTOM_LEFT = 'BOTTOM_LEFT';
    const CONTROL_POSITION_BOTTOM_RIGHT = 'BOTTOM_RIGHT';
    const CONTROL_POSITION_LEFT_BOTTOM = 'LEFT_BOTTOM';
    const CONTROL_POSITION_LEFT_CENTER = 'LEFT_CENTER';
    const CONTROL_POSITION_LEFT_TOP = 'LEFT_TOP';
    const CONTROL_POSITION_RIGHT_BOTTOM = 'RIGHT_BOTTOM';
    const CONTROL_POSITION_RIGHT_CENTER = 'RIGHT_CENTER';
    const CONTROL_POSITION_RIGHT_TOP = 'RIGHT_TOP';
    const CONTROL_POSITION_TOP_CENTER = 'TOP_CENTER';
    const CONTROL_POSITION_TOP_LEFT = 'TOP_LEFT';
    const CONTROL_POSITION_TOP_RIGHT = 'TOP_RIGHT';

    const MAP_TYPE_CONTROL_STYLE_DEFAULT = 'DEFAULT';
    const MAP_TYPE_CONTROL_STYLE_DROPDOWN_MENU = 'DROPDOWN_MENU';
    const MAP_TYPE_CONTROL_STYLE_HORIZONTAL_BAR = 'HORIZONTAL_BAR';

    const SCALE_CONTROL_STYLE_DEFAULT = 'DEFAULT';

    const ZOOM_CONTROL_STYLE_DEFAULT = 'DEFAULT';
    const ZOOM_CONTROL_STYLE_LARGE = 'LARGE';
    const ZOOM_CONTROL_STYLE_SMALL = 'SMALL';

    const URL_FETCH_METHOD_CURL = 'curl';
    const URL_FETCH_METHOD_SOCKETS = 'sockets';

    const ANIMATION_BOUNCE = 'BOUNCE';
    const ANIMATION_DROP = 'DROP';

    protected $_id = '';
    protected $_width = 600;
    protected $_height = 600;
    protected $_fullScreen = false;

    protected $_lat = 51.522784;
    protected $_lng = 0.020168;

    protected $_sensor = false;
    protected $_geoMarker = null;
    protected $_overrideCenterByGeo = false;

    protected $_backgroundColor = null;
    protected $_disableDefaultUI = null;
    protected $_disableDoubleClickZoom = null;
    protected $_draggable = null;
    protected $_draggableCursor = null;
    protected $_draggingCursor = null;
    protected $_heading = null;
    protected $_keyboardShortcuts = null;
    protected $_mapMaker = null;
    protected $_mapTypeControl = null;
    protected $_mapTypeControlIds = array(self::MAP_TYPE_ID_HYBRID, self::MAP_TYPE_ID_ROADMAP, self::MAP_TYPE_ID_SATELLITE, self::MAP_TYPE_ID_TERRAIN);
    protected $_mapTypeControlPosition = self::CONTROL_POSITION_RIGHT_TOP;
    protected $_mapTypeControlStyle = self::MAP_TYPE_CONTROL_STYLE_DEFAULT;
    protected $_mapTypeId = self::MAP_TYPE_ID_HYBRID;
    protected $_maxZoom = null;
    protected $_minZoom = null;
    protected $_noClear = null;
    protected $_overviewMapControl = null;
    protected $_overviewMapControlOpened = null;
    protected $_panControl = null;
    protected $_panControlPosition = self::CONTROL_POSITION_LEFT_TOP;
    protected $_rotateControl = null;
    protected $_rotateControlPosition = self::CONTROL_POSITION_LEFT_TOP;
    protected $_scaleControl = null;
    protected $_scaleControlStyle = self::SCALE_CONTROL_STYLE_DEFAULT;
    protected $_scaleControlPosition = self::CONTROL_POSITION_LEFT_BOTTOM;
    protected $_scrollwheel = null;
    protected $_streetViewControl = null;
    protected $_streetViewControlPosition = null;
    protected $_tilt = null;
    protected $_zoom = 15;
    protected $_zoomControl = null;
    protected $_zoomControlPosition = self::CONTROL_POSITION_LEFT_TOP;
    protected $_zoomControlStyle = self::ZOOM_CONTROL_STYLE_DEFAULT;

    protected $_markers = array();
    protected $_polylines = array();
    protected $_polygons = array();
    public $_setBounds = FALSE;
    public $apiKey = "";

    protected static $defMarkerOptions = array(
        'animation' => null,
        'clickable' => null,
        'cursor' => null,
        'draggable' => null,
        'flat' => null,
        'icon' => null,
        'defColor' => null,
        'defSymbol' => null,
        'optimized' => null,
        'raiseOnDrag' => null,
        'shadow' => null,
        'shape' => null,
        'title' => null,
        'visible' => null,
        'zIndex' => null,
        'html' => null,
        'infoMaxWidth' => null,
        'infoDisableAutoPan' => null,
        'infoZIndex' => null,
        'infoCloseOthers' => false,
    );

    public function __construct($id = '')
    {
        $this->setId($id);
    }

    public function setId($id)
    {
        $this->_id = ($id == '' ? 'map' . mt_rand(10000, 99999) : $id);
    }
    public function setApiKey($key){
        $this->apiKey = $key;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setSize($width, $height)
    {
        $this->_width = $width;
        $this->_height = $height;
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function setFullScreen($fullScreen)
    {
        $this->_fullScreen = $fullScreen;
    }

    public function getFullScreen()
    {
        return $this->_fullScreen;
    }

    public function setCenter($lat, $lng)
    {
        $this->_lat = $lat;
        $this->_lng = $lng;
    }

    public function getCenterLat()
    {
        return $this->_lat;
    }

    public function getCenterLng()
    {
        return $this->_lng;
    }

    public function setSensor($sensor)
    {
        $this->_sensor = $sensor;
    }

    public function getSensor()
    {
        return $this->_sensor;
    }

    public function setDisableDefaultUI($disableDefaultUI)
    {
        $this->_disableDefaultUI = $disableDefaultUI;
    }

    public function getDisableDefaultUI()
    {
        return $this->_disableDefaultUI;
    }

    public function setDisableDoubleClickZoom($disableDoubleClickZoom)
    {
        $this->_disableDoubleClickZoom = $disableDoubleClickZoom;
    }

    public function getDisableDoubleClickZoom()
    {
        return $this->_disableDoubleClickZoom;
    }

    public function setDraggable($draggable)
    {
        $this->_draggable = $draggable;
    }

    public function getDraggable()
    {
        return $this->_draggable;
    }

    public function setDraggableCursor($draggableCursor)
    {
        $this->_draggableCursor = $draggableCursor;
    }

    public function getDraggableCursor()
    {
        return $this->_draggableCursor;
    }

    public function setDraggingCursor($draggingCursor)
    {
        $this->_draggingCursor = $draggingCursor;
    }

    public function getDraggingCursor()
    {
        return $this->_draggingCursor;
    }

    public function setHeading($heading)
    {
        $this->_heading = abs(intval($heading));
    }

    public function getHeading()
    {
        return $this->_heading;
    }

    public function setKeyboardShortcuts($keyboardShortcuts)
    {
        $this->_keyboardShortcuts = $keyboardShortcuts;
    }

    public function getKeyboardShortcuts()
    {
        return $this->_keyboardShortcuts;
    }

    public function setMapMaker($mapMaker)
    {
        $this->_mapMaker = $mapMaker;
    }

    public function getMapMaker()
    {
        return $this->_mapMaker;
    }

    public function setMapTypeControl($mapTypeControl)
    {
        $this->_mapTypeControl = $mapTypeControl;
    }

    public function getMapTypeControl()
    {
        return $this->_mapTypeControl;
    }

    public function setMapTypeControlIds($mapTypeControlIds)
    {
        $this->_mapTypeControlIds = $mapTypeControlIds;
    }

    public function getMapTypeControlIds()
    {
        return $this->_mapTypeControlIds;
    }

    public function setMapTypeControlPosition($mapTypeControlPosition)
    {
        $this->_mapTypeControlPosition = $mapTypeControlPosition;
    }

    public function getMapTypeControlPosition()
    {
        return $this->_mapTypeControlPosition;
    }

    public function setMapTypeControlStyle($mapTypeControlStyle)
    {
        $this->_mapTypeControlStyle = $mapTypeControlStyle;
    }

    public function getMapTypeControlStyle()
    {
        return $this->_mapTypeControlStyle;
    }

    public function setMapTypeId($mapTypeId)
    {
        $this->_mapTypeId = $mapTypeId;
    }

    public function getMapTypeId()
    {
        return $this->_mapTypeId;
    }

    public function setMaxZoom($maxZoom)
    {
        $this->_maxZoom = abs(intval($maxZoom));
    }

    public function getMaxZoom()
    {
        return $this->_maxZoom;
    }

    public function setMinZoom($minZoom)
    {
        $this->_minZoom = abs(intval($minZoom));
    }

    public function getMinZoom()
    {
        return $this->_minZoom;
    }

    public function setNoClear($noClear)
    {
        $this->_noClear = $noClear;
    }

    public function getNoClear()
    {
        return $this->_noClear;
    }

    public function setOverviewMapControl($overviewMapControl)
    {
        $this->_overviewMapControl = $overviewMapControl;
    }

    public function getOverviewMapControl()
    {
        return $this->_overviewMapControl;
    }

    public function setOverviewMapControlOpened($overviewMapControlOpened)
    {
        $this->_overviewMapControlOpened = $overviewMapControlOpened;
    }

    public function getOverviewMapControlOpened()
    {
        return $this->_overviewMapControlOpened;
    }

    public function setPanControl($panControl)
    {
        $this->_panControl = $panControl;
    }

    public function getPanControl()
    {
        return $this->_panControl;
    }

    public function setPanControlPosition($panControlPosition)
    {
        $this->_panControlPosition = $panControlPosition;
    }

    public function getPanControlPosition()
    {
        return $this->_panControlPosition;
    }

    public function setRotateControl($rotateControl)
    {
        $this->_rotateControl = $rotateControl;
    }

    public function getRotateControl()
    {
        return $this->_rotateControl;
    }

    public function setRotateControlPosition($rotateControlPosition)
    {
        $this->_rotateControlPosition = $rotateControlPosition;
    }

    public function getRotateControlPosition()
    {
        return $this->_rotateControlPosition;
    }

    public function setScaleControl($scaleControl)
    {
        $this->_scaleControl = $scaleControl;
    }

    public function getScaleControl()
    {
        return $this->_scaleControl;
    }

    public function setScaleControlStyle($scaleControlStyle)
    {
        $this->_scaleControlStyle = $scaleControlStyle;
    }

    public function getScaleControlStyle()
    {
        return $this->_scaleControlStyle;
    }

    public function setScaleControlPosition($scaleControlPosition)
    {
        $this->_scaleControlPosition = $scaleControlPosition;
    }

    public function getScaleControlPosition()
    {
        return $this->_scaleControlPosition;
    }

    public function setScrollwheel($scrollwheel)
    {
        $this->_scrollwheel = $scrollwheel;
    }

    public function getScrollwheel()
    {
        return $this->_scrollwheel;
    }

    public function setStreetViewControl($streetViewControl)
    {
        $this->_streetViewControl = $streetViewControl;
    }

    public function getStreetViewControl()
    {
        return $this->_streetViewControl;
    }

    public function setStreetViewControlPosition($streetViewControlPosition)
    {
        $this->_streetViewControlPosition = $streetViewControlPosition;
    }

    public function getStreetViewControlPosition()
    {
        return $this->_streetViewControlPosition;
    }

    public function setTilt($tilt)
    {
        $this->_tilt = abs(intval($tilt));
    }

    public function getTilt()
    {
        return $this->_tilt;
    }

    public function setZoom($zoom)
    {
        $this->_zoom = abs(intval($zoom));
    }

    public function getZoom()
    {
        return $this->_zoom;
    }

    public function setZoomControl($zoomControl)
    {
        $this->_zoomControl = $zoomControl;
    }

    public function getZoomControl()
    {
        return $this->_zoomControl;
    }

    public function setZoomControlPosition($zoomControlPosition)
    {
        $this->_zoomControlPosition = $zoomControlPosition;
    }

    public function getZoomControlPosition()
    {
        return $this->_zoomControlPosition;
    }

    public function setZoomControlStyle($zoomControlStyle)
    {
        $this->_zoomControlStyle = $zoomControlStyle;
    }

    public function getZoomControlStyle()
    {
        return $this->_zoomControlStyle;
    }

    protected function _getByCurl($url)
    {
        if (!function_exists('curl_init')) {
            throw new MapbuilderException('cURL extension not installed.');
        }
        if (!($curl = curl_init($url))) {
            throw new MapbuilderException('Unable to initialize a cURL session.');
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if (false === ($response = curl_exec($curl))) {
            throw new MapbuilderException(curl_error($curl));
        }
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpStatus != 200) {
            throw new MapbuilderException($response);
        }
        return $response;
    }

    protected function _getBySockets($url)
    {
        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'];
        $port = (isset($parsedUrl['port']) ? $parsedUrl['port'] : '80');
        $path = (isset($parsedUrl['path']) ? $parsedUrl['path'] : '/');
        if (isset($parsedUrl['query'])) {
            $path .= '?' . $parsedUrl['query'];
        }
        $timeout = 10;
        $response = '';
        if (!($fp = @fsockopen($host, $port, $errNo, $errStr, $timeout))) {
            throw new MapbuilderException('Socket error #{' . $errNo . '}: {' . $errStr . '}');
        }
        fputs($fp, "GET $path HTTP/1.0\r\n" .
            "Host: $host\r\n" .
            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
            "Accept: */*\r\n" .
            "Accept-Language: en-us,en;q=0.5\r\n" .
            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
            "Keep-Alive: 300\r\n" .
            "Connection: keep-alive\r\n" .
            "Referer: http://$host\r\n\r\n"
        );
        while ($line = fread($fp, 4096)) {
            $response .= $line;
        }
        fclose($fp);
        $responseBody = substr($response, strpos($response, "\r\n\r\n") + 4);
        list($firstLine) = explode("\r\n", $response);
        if (false === strpos($firstLine, ' 200 OK')) {
           throw new MapbuilderException($responseBody);
        }
        return $responseBody;
    }

    public function getLatLng($address, $urlFetchMethod = self::URL_FETCH_METHOD_SOCKETS)
    {
        $address = str_replace('�', '\'', $address);
        $url = '//maps.googleapis.com/maps/api/geocode/json?address=' . rawurlencode($address);
        if ($urlFetchMethod == self::URL_FETCH_METHOD_SOCKETS) {
            $json = $this->_getBySockets($url);
        } else {
            $json = $this->_getByCurl($url);
        }
        $resp = json_decode($json);
        if (isset($resp->results[0]->geometry->location->lat)) {
            $lat = $resp->results[0]->geometry->location->lat;
            $lng = $resp->results[0]->geometry->location->lng;
            return array('lat' => $lat, 'lng' => $lng);
        } else {
            throw new MapbuilderException('Unable to get coordinates. JSON parser error.');
        }
    }

    public function addMarker($lat, $lng, $options = array())
    {
        $opts = self::$defMarkerOptions;
        foreach ($options as $k => $v) {
            $opts[$k] = $v;
        }
        $this->_markers[] = array(
            'lat' => $lat,
            'lng' => $lng,
            'options' => $opts
        );
        return sizeof($this->_markers) - 1;
    }

    public function getMarkerLat($index)
    {
        if (isset($this->_markers[$index])) {
            return $this->_markers[$index]['lat'];
        } else {
            return false;
        }
    }

    public function getMarkerLng($index)
    {
        if (isset($this->_markers[$index])) {
            return $this->_markers[$index]['lng'];
        } else {
            return false;
        }
    }

    public function getMarkerOptions($index)
    {
        if (isset($this->_markers[$index])) {
            return $this->_markers[$index]['options'];
        } else {
            return false;
        }
    }

    public function getNumMarkers()
    {
        return sizeof($this->_markers);
    }

    public function removeMarker($index)
    {
        if (isset($this->_markers[$index])) {
            unset($this->_markers[$index]);
            return true;
        } else {
            return false;
        }
    }

    public function clearMarkers()
    {
        $this->_markers = array();
    }

    public function addGeoMarker($options = array())
    {
        $opts = self::$defMarkerOptions;
        foreach ($options as $k => $v) {
            $opts[$k] = $v;
        }
        $this->_geoMarker = array(
            'options' => $opts
        );
        $this->_sensor = true;
    }

    public function removeGeoMarker($resetSensor = true)
    {
        $this->_geoMarker = null;
        if (!$this->_overrideCenterByGeo && $resetSensor) {
            $this->_sensor = false;
        }
    }

    public function overrideCenterByGeo($override = true, $resetSensor = true)
    {
        $this->_overrideCenterByGeo = $override;
        if ($override) {
            $this->_sensor = true;
        } elseif (is_null($this->_geoMarker) && $resetSensor) {
            $this->_sensor = false;
        }
    }

    public function addPolyline($path, $color = '#000000', $weight = 1, $opacity = 1.0)
    {
        $this->_polylines[] = array(
            'path' => $path,
            'color' => $color,
            'weight' => $weight,
            'opacity' => $opacity
        );
        return sizeof($this->_polylines) - 1;
    }

    public function getNumPolylines()
    {
        return sizeof($this->_polylines);
    }

    public function removePolyline($index)
    {
        if (isset($this->_polylines[$index])) {
            unset($this->_polylines[$index]);
            return true;
        } else {
            return false;
        }
    }

    public function clearPolylines()
    {
        $this->_polylines = array();
    }

    public function addPolygon($path, $strokeColor = '#000000', $fillColor = '#FF0000', $strokeWeight = 1, $strokeOpacity = 1.0, $fillOpacity = 0.35)
    {
        $this->_polygons[] = array(
            'path' => $path,
            'strokeColor' => $strokeColor,
            'fillColor' => $fillColor,
            'strokeWeight' => $strokeWeight,
            'strokeOpacity' => $strokeOpacity,
            'fillOpacity' => $fillOpacity
        );
        return sizeof($this->_polygons) - 1;
    }

    public function getNumPolygons()
    {
        return sizeof($this->_polygons);
    }

    public function removePolygon($index)
    {
        if (isset($this->_polygons[$index])) {
            unset($this->_polygons[$index]);
            return true;
        } else {
            return false;
        }
    }

    public function clearPolygons()
    {
        $this->_polygons = array();
    }

    public function show($output = true)
    {
        $html = '';
        $html .= '<script type="text/javascript" src="//maps.google.com/maps/api/js?key=' . $this->apiKey . '"></script>' . "\n";
        $html .= '<script type="text/javascript">' . "\n";
        $html .= '<!--' . "\n";
        $html .= 'var map;' . "\n";
        $html .= 'var markers = new Array();' . "\n";
        $html .= 'var infos = new Array();' . "\n";
        $html .= 'var polylines = new Array();' . "\n";
        $html .= 'var polygons = new Array();' . "\n";
        $html .= 'var geoMarker = null;' . "\n";
        $html .= 'var geoInfo = null;' . "\n";
        $html .= 'function initialize() {' . "\n";
        $html .= '    var latlng = new google.maps.LatLng(' . $this->_lat . ', ' . $this->_lng . ');' . "\n";
        $html .= '   var bounds = new google.maps.LatLngBounds();' . "\n";

        $html .= '    var mapTypeControlOptions = {' . "\n";
        $html .= '        mapTypeIds: [';
        foreach ($this->_mapTypeControlIds as $id) {
            $html .= 'google.maps.MapTypeId.' . $id . ', ';
        }
        $html = substr($html, 0, -2);
        $html .= '],' . "\n";
        $html .= '        position: google.maps.ControlPosition.' . $this->_mapTypeControlPosition . ',' . "\n";
        $html .= '        style: google.maps.MapTypeControlStyle.' . $this->_mapTypeControlStyle . "\n";
        $html .= '    };' . "\n";

        $html .= '    var overviewMapControlOptions = {' . "\n";
        $html .= '        opened: ' . ($this->_overviewMapControlOpened ? 'true' : 'false') . "\n";
        $html .= '    };' . "\n";

        $html .= '    var panControlOptions = {' . "\n";
        $html .= '        position: google.maps.ControlPosition.' . $this->_panControlPosition . "\n";
        $html .= '    };' . "\n";

        $html .= '    var rotateControlOptions = {' . "\n";
        $html .= '        position: google.maps.ControlPosition.' . $this->_rotateControlPosition . "\n";
        $html .= '    };' . "\n";

        $html .= '    var scaleControlOptions = {' . "\n";
        $html .= '        position: google.maps.ControlPosition.' . $this->_scaleControlPosition . ',' . "\n";
        $html .= '        style: google.maps.ScaleControlStyle.' . $this->_scaleControlStyle . "\n";
        $html .= '    };' . "\n";

        if (!is_null($this->_streetViewControlPosition)) {
            $html .= '    var streetViewControlOptions = {' . "\n";
            $html .= '        position: google.maps.ControlPosition.' . $this->_streetViewControlPosition . "\n";
            $html .= '    };' . "\n";
        }

        $html .= '    var zoomControlOptions = {' . "\n";
        $html .= '        position: google.maps.ControlPosition.' . $this->_zoomControlPosition . ',' . "\n";
        $html .= '        style: google.maps.ZoomControlStyle.' . $this->_zoomControlStyle . "\n";
        $html .= '    };' . "\n";

        $html .= '    var myOptions = {' . "\n";

        if (!is_null($this->_backgroundColor)) {
            $html .= '        backgroundColor: "' . htmlspecialchars($this->_backgroundColor) . '",' . "\n";
        }
        if (!is_null($this->_disableDefaultUI)) {
            $html .= '        disableDefaultUI: ' . ($this->_disableDefaultUI ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_disableDoubleClickZoom)) {
            $html .= '        disableDoubleClickZoom: ' . ($this->_disableDoubleClickZoom ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_draggable)) {
            $html .= '        draggable: ' . ($this->_draggable ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_draggableCursor)) {
            $html .= '        draggableCursor: "' . $this->_draggableCursor . '",' . "\n";
        }
        if (!is_null($this->_draggingCursor)) {
            $html .= '        draggingCursor: "' . $this->_draggingCursor . '",' . "\n";
        }
        if (!is_null($this->_heading)) {
            $html .= '        heading: ' . abs(intval($this->_heading)) . ',' . "\n";
        }
        if (!is_null($this->_keyboardShortcuts)) {
            $html .= '        keyboardShortcuts: ' . ($this->_keyboardShortcuts ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_mapMaker)) {
            $html .= '        mapMaker: ' . ($this->_mapMaker ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_mapTypeControl)) {
            $html .= '        mapTypeControl: ' . ($this->_mapTypeControl ? 'true' : 'false') . ',' . "\n";
        }
        $html .= '        mapTypeControlOptions: mapTypeControlOptions,' . "\n";
        $html .= '        mapTypeId: google.maps.MapTypeId.' . $this->_mapTypeId . ',' . "\n";

        if (!is_null($this->_maxZoom)) {
            $html .= '        maxZoom: ' . abs(intval($this->_maxZoom)) . ',' . "\n";
        }
        if (!is_null($this->_minZoom)) {
            $html .= '        minZoom: ' . abs(intval($this->_minZoom)) . ',' . "\n";
        }

        if (!is_null($this->_noClear)) {
            $html .= '        noClear: ' . ($this->_noClear ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_overviewMapControl)) {
            $html .= '        overviewMapControl: ' . ($this->_overviewMapControl ? 'true' : 'false') . ',' . "\n";
        }
        $html .= '        overviewMapControlOptions: overviewMapControlOptions,' . "\n";

        if (!is_null($this->_panControl)) {
            $html .= '        panControl: ' . ($this->_panControl ? 'true' : 'false') . ',' . "\n";
        }
        $html .= '        panControlOptions: panControlOptions,' . "\n";

        if (!is_null($this->_rotateControl)) {
            $html .= '        rotateControl: ' . ($this->_rotateControl ? 'true' : 'false') . ',' . "\n";
        }
        $html .= '        rotateControlOptions: rotateControlOptions,' . "\n";

        if (!is_null($this->_scaleControl)) {
            $html .= '        scaleControl: ' . ($this->_scaleControl ? 'true' : 'false') . ',' . "\n";
        }
        $html .= '        scaleControlOptions: scaleControlOptions,' . "\n";

        if (!is_null($this->_scrollwheel)) {
            $html .= '        scrollwheel: ' . ($this->_scrollwheel ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_streetViewControl)) {
            $html .= '        streetViewControl: ' . ($this->_streetViewControl ? 'true' : 'false') . ',' . "\n";
        }
        if (!is_null($this->_streetViewControlPosition)) {
            $html .= '        streetViewControlOptions: streetViewControlOptions,' . "\n";
        }
        if (!is_null($this->_tilt)) {
            $html .= '        tilt: ' . abs(intval($this->_tilt)) . ',' . "\n";
        }
        $html .= '        zoom: ' . abs(intval($this->_zoom)) . ',' . "\n";
        if (!is_null($this->_zoomControl)) {
            $html .= '        zoomControl: ' . ($this->_zoomControl ? 'true' : 'false') . ',' . "\n";
        }
        $html .= '        zoomControlOptions: zoomControlOptions,' . "\n";

        $html .= '        center: latlng' . "\n";
        $html .= '    };' . "\n";
        $html .= '    map = new google.maps.Map(document.getElementById("' . $this->_id . '"), myOptions); ' . "\n";

        foreach ($this->_markers as $i => $marker) {
            $html .= '    markers['. $i . '] = new google.maps.Marker({' . "\n";

            if (!is_null($marker['options']['animation'])) {
                $html .= '        animation: google.maps.Animation.' . $marker['options']['animation'] . ',' . "\n";
            }
            if (!is_null($marker['options']['clickable'])) {
                $html .= '        clickable: ' . ($marker['options']['clickable'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['cursor'])) {
                $html .= '        cursor: "' . $marker['options']['cursor'] . '",' . "\n";
            }
            if (!is_null($marker['options']['draggable'])) {
                $html .= '        draggable: ' . ($marker['options']['draggable'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['flat'])) {
                $html .= '        flat: ' . ($marker['options']['flat'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['icon'])) {
                $html .= '        icon: "' . $marker['options']['icon'] . '",' . "\n";
            }
            if (is_null($marker['options']['icon']) || $marker['options']['icon'] == '') {
                if (!is_null($marker['options']['defSymbol']) || !is_null($marker['options']['defColor'])) {
                    $sym = (!is_null($marker['options']['defSymbol']) ? $marker['options']['defSymbol'] : '%E2%80%A2');
                    $col = (!is_null($marker['options']['defColor']) ? $marker['options']['defColor'] : 'FE7569');
                    $col = ltrim($col, '#');
                    $defIconUrl = '//chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' . $sym . '|' . $col;
                    $html .= '        icon: "' . $defIconUrl . '",' . "\n";
                }
            }
            if (!is_null($marker['options']['optimized'])) {
                $html .= '        optimized: ' . ($marker['options']['optimized'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['raiseOnDrag'])) {
                $html .= '        raiseOnDrag: ' . ($marker['options']['raiseOnDrag'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['shadow'])) {
                $html .= '        shadow: ' . ($marker['options']['shadow'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['title'])) {
                $html .= '        title: "' . htmlspecialchars($marker['options']['title']) . '",' . "\n";
            }
            if (!is_null($marker['options']['visible'])) {
                $html .= '        visible: ' . ($marker['options']['visible'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($marker['options']['zIndex'])) {
                $html .= '        zIndex: ' . abs(intval($marker['options']['zIndex'])) . ',' . "\n";
            }

            $html .= '        position: new google.maps.LatLng(' . $marker['lat'] . ', ' . $marker['lng'] . '),' . "\n";
            $html .= '        map: map' . "\n";
            $html .= '    });' . "\n";
if($this->_setBounds){
            $html .= '  bounds.extend(new google.maps.LatLng(' . $marker['lat'] . ', ' . $marker['lng'] . ')); console.log(bounds); map.fitBounds(bounds);' . "\n";
}
            if (!empty($marker['options']['html'])) {
                $html .= '    infos[' . $i . '] = new google.maps.InfoWindow({' . "\n";

                if (!is_null($marker['options']['infoMaxWidth'])) {
                    $html .= '        maxWidth: ' . abs(intval($marker['options']['infoMaxWidth'])) . ',' . "\n";
                }
                if (!is_null($marker['options']['infoDisableAutoPan'])) {
                    $html .= '        disableAutoPan: ' . ($marker['options']['infoDisableAutoPan'] ? 'true' : 'false') . ',' . "\n";
                }
                if (!is_null($marker['options']['infoZIndex'])) {
                    $html .= '        zIndex: ' . abs(intval($marker['options']['infoZIndex'])) . ',' . "\n";
                }

                $html .= '        content: "' . addslashes($marker['options']['html']) . '"' . "\n";

                $html .= '    });' . "\n";
                $html .= '    google.maps.event.addListener(markers[' . $i . '], "click", function() {' . "\n";

                if ($marker['options']['infoCloseOthers']) {
                    $html .= '        for (i = 0; i < infos.length; i++) {' . "\n";
                    $html .= '            if (infos[i] != null) { infos[i].close(); }' . "\n";
                    $html .= '        }' . "\n";
                    $html .= '        if (geoInfo != null) { geoInfo.close(); }' . "\n";
                }
                $html .= '        infos[' . $i . '].open(map, markers[' . $i . ']);' . "\n";
                $html .= '    });' . "\n";
            } else {
                $html .= '    infos[' . $i . '] = null;' . "\n";
            }
        }

        foreach ($this->_polylines as $i => $polyline) {
            $numPoints = sizeof($polyline['path']);
            $html .= '    polylines[' . $i . '] = new google.maps.Polyline({' . "\n";
            $html .= '        path: [' . "\n";
            foreach ($polyline['path'] as $j => $point) {
                $html .= '            new google.maps.LatLng(' . $point[0] . ', ' . $point[1] . ')' . ($j < $numPoints - 1 ? ',' : '') . "\n";
            }
            $html .= '        ],' . "\n";
            $html .= '        strokeColor: "' . $polyline['color'] . '",' . "\n";
            $html .= '        strokeWeight: "' . $polyline['weight'] . '",' . "\n";
            $html .= '        strokeOpacity: "' . $polyline['opacity'] . '"' . "\n";
            $html .= '    });' . "\n";
            $html .= '    polylines[' . $i . '].setMap(map);' . "\n";
        }

        foreach ($this->_polygons as $i => $polygon) {
            $numPoints = sizeof($polygon['path']);
            $html .= '    polygons[' . $i . '] = new google.maps.Polygon({' . "\n";
            $html .= '        path: [' . "\n";
            foreach ($polygon['path'] as $j => $point) {
                $html .= '            new google.maps.LatLng(' . $point[0] . ', ' . $point[1] . ')' . ($j < $numPoints - 1 ? ',' : '') . "\n";
            }
            $html .= '        ],' . "\n";
            $html .= '        strokeColor: "' . $polygon['strokeColor'] . '",' . "\n";
            $html .= '        strokeWeight: "' . $polygon['strokeWeight'] . '",' . "\n";
            $html .= '        strokeOpacity: "' . $polygon['strokeOpacity'] . '",' . "\n";
            $html .= '        fillColor: "' . $polygon['fillColor'] . '",' . "\n";
            $html .= '        fillOpacity: "' . $polygon['fillOpacity'] . '"' . "\n";
            $html .= '    });' . "\n";
            $html .= '    polygons[' . $i . '].setMap(map);' . "\n";
        }

        if (!is_null($this->_geoMarker)) {

            $html .= '    if (navigator.geolocation) {' . "\n";
            $html .= '        navigator.geolocation.getCurrentPosition(function(position) {' . "\n";
            $html .= '            gpsLat = position.coords.latitude;' . "\n";
            $html .= '            gpsLng = position.coords.longitude;' . "\n";

            $html .= '            geoMarker = new google.maps.Marker({' . "\n";

            if (!is_null($this->_geoMarker['options']['animation'])) {
                $html .= '                animation: google.maps.Animation.' . $this->_geoMarker['options']['animation'] . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['clickable'])) {
                $html .= '                clickable: ' . ($this->_geoMarker['options']['clickable'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['cursor'])) {
                $html .= '                cursor: "' . $this->_geoMarker['options']['cursor'] . '",' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['draggable'])) {
                $html .= '                draggable: ' . ($this->_geoMarker['options']['draggable'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['flat'])) {
                $html .= '                flat: ' . ($this->_geoMarker['options']['flat'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['icon'])) {
                $html .= '                icon: "' . $this->_geoMarker['options']['icon'] . '",' . "\n";
            }
            if (is_null($this->_geoMarker['options']['icon']) || $this->_geoMarker['options']['icon'] == '') {
                if (!is_null($this->_geoMarker['options']['defSymbol']) || !is_null($this->_geoMarker['options']['defColor'])) {
                    $sym = (!is_null($this->_geoMarker['options']['defSymbol']) ? $this->_geoMarker['options']['defSymbol'] : '%E2%80%A2');
                    $col = (!is_null($this->_geoMarker['options']['defColor']) ? $this->_geoMarker['options']['defColor'] : 'FE7569');
                    $col = ltrim($col, '#');
                    $defIconUrl = '//chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' . $sym . '|' . $col;
                    $html .= '                icon: "' . $defIconUrl . '",' . "\n";
                }
            }
            if (!is_null($this->_geoMarker['options']['optimized'])) {
                $html .= '                optimized: ' . ($this->_geoMarker['options']['optimized'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['raiseOnDrag'])) {
                $html .= '                raiseOnDrag: ' . ($this->_geoMarker['options']['raiseOnDrag'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['shadow'])) {
                $html .= '                shadow: ' . ($this->_geoMarker['options']['shadow'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['title'])) {
                $html .= '                title: "' . htmlspecialchars($this->_geoMarker['options']['title']) . '",' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['visible'])) {
                $html .= '                visible: ' . ($this->_geoMarker['options']['visible'] ? 'true' : 'false') . ',' . "\n";
            }
            if (!is_null($this->_geoMarker['options']['zIndex'])) {
                $html .= '                zIndex: ' . abs(intval($this->_geoMarker['options']['zIndex'])) . ',' . "\n";
            }

            $html .= '                position: new google.maps.LatLng(gpsLat, gpsLng),' . "\n";
            $html .= '                map: map' . "\n";
            $html .= '            });' . "\n";
            if (!empty($this->_geoMarker['options']['html'])) {
                $html .= '            geoInfo = new google.maps.InfoWindow({' . "\n";

                if (!is_null($this->_geoMarker['options']['infoMaxWidth'])) {
                    $html .= '                maxWidth: ' . abs(intval($this->_geoMarker['options']['infoMaxWidth'])) . ',' . "\n";
                }
                if (!is_null($this->_geoMarker['options']['infoDisableAutoPan'])) {
                    $html .= '                disableAutoPan: ' . ($this->_geoMarker['options']['infoDisableAutoPan'] ? 'true' : 'false') . ',' . "\n";
                }
                if (!is_null($this->_geoMarker['options']['infoZIndex'])) {
                    $html .= '                zIndex: ' . abs(intval($this->_geoMarker['options']['infoZIndex'])) . ',' . "\n";
                }

                $html .= '                content: "' . addslashes($this->_geoMarker['options']['html']) . '"' . "\n";

                $html .= '            });' . "\n";
                $html .= '            google.maps.event.addListener(geoMarker, "click", function() {' . "\n";
                if ($this->_geoMarker['options']['infoCloseOthers']) {
                    $html .= '                for (i = 0; i < infos.length; i++) {' . "\n";
                    $html .= '                    if (infos[i] != null) { infos[i].close(); }' . "\n";
                    $html .= '                }' . "\n";
                    $html .= '                if (geoInfo != null) { geoInfo.close(); }' . "\n";
                }
                $html .= '                geoInfo.open(map, geoMarker);' . "\n";
                $html .= '            });' . "\n";

            }

            if ($this->_overrideCenterByGeo) {
                $html .= '            map.setCenter(new google.maps.LatLng(gpsLat, gpsLng));' . "\n";
            }

            $html .= '        }, function (error) {' . "\n";
            $html .= '	          switch(error.code) {' . "\n";
            $html .= '            case error.TIMEOUT:' . "\n";
            $html .= '		          alert("Geolocation error: Timeout.");' . "\n";
            $html .= '			      break;' . "\n";
            $html .= '		      case error.POSITION_UNAVAILABLE:' . "\n";
            $html .= '			      alert ("Geolocation error: Position unavailable.");' . "\n";
            $html .= '			      break;' . "\n";
            $html .= '		      case error.PERMISSION_DENIED:' . "\n";
            $html .= '			      alert("Geolocation error: Permission denied.");' . "\n";
            $html .= '			      break;' . "\n";
            $html .= '		      case error.UNKNOWN_ERROR:' . "\n";
            $html .= '			      alert ("Geolocation error: Unknown error.");' . "\n";
            $html .= '			      break;' . "\n";
            $html .= '    	      }' . "\n";
            $html .= '	      });' . "\n";
            $html .= '    }' . "\n";

        }

        $html .= 'if (typeof mbOnAfterInit == "function") mbOnAfterInit(map);' . "\n";

        $html .= '}' . "\n";
        $html .= 'window.onload = initialize;' . "\n";
        $html .= '//-->' . "\n";
        $html .= '</script>' . "\n";
        $html .= '<div id="' . $this->_id . '" style="' . ($this->_fullScreen ? 'width:100%;height:100%' : 'width:' . $this->_width .';height:' . $this->_height) . '"></div>' . "\n";
        if ($output) {
            echo $html;
            return '';
        } else {
            return $html;
        }
    }
}
