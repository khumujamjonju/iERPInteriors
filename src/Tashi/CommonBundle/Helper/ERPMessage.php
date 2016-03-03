<?php
/**
 * Module Name :
 * Purpose or objective of the  page :
 * Created By :
 * Created Date :
 * Last Modified Date :
 * Last Modified By :
 * Test Carried Out :
 * Test Carried By :
 * Version :
 */

namespace Tashi\CommonBundle\Helper;                // package declaration

class ERPMessage {

    private $message;
    private $errors;
    private $success;
    private $html;
    private $secondHtml;
    private $page;
    private $path;
    private $id;
    private $jsonData;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function setErrors($errors) {
        $this->errors = $errors;
    }

    public function getSuccess() {
        return $this->success;
    }

    public function setSuccess($success) {
        $this->success = $success;
    }

    public function getHtml() {
        return $this->html;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

    public function getSecondHtml() {
        return $this->secondHtml;
    }

    public function setSecondHtml($secondHtml) {
        $this->secondHtml = $secondHtml;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
    }
    
    public function getJsonData() {
        return $this->jsonData;
    }
    public function setJsonData($jsonData) {
        $this->jsonData = $jsonData;
    }

}
