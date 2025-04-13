<?php 

class SmsTemplateManager {

    const STORE = APPPATH . "json/sms_api_template.json";
    public $document;

    public function __construct()
    {
        $this->document = file_get_contents(self::STORE) or die('Unable to load template document');
    }

    public function get($id = 0)
    {
        if(empty($id)) {
            return $this->document;
        } else {
            $documents = json_decode($this->document);
            foreach($documents as $document) {
                foreach($document->templates as $index => $template) {
                    if($template->id == $id) {
                        return $template;
                    }
                }
            }
        }
    }

    public function update($id, $data)
    {
        $updatedObject;
        $documents = json_decode($this->document);
        foreach($documents as $document) {
            foreach($document->templates as $index => $template) {
                if($template->id == $id) {
                    $document->templates[$index] = $data;
                    $updatedObject = $data;
                }
            }
        }

        $this->document = json_encode($documents, JSON_PRETTY_PRINT);
        file_put_contents(self::STORE, $this->document);

        return $updatedObject;
    }
}