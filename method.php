<?php
  class Method{
    private $name;
    private $datatime;
    private $body;
    private $img;


    public function __construct($name, $datatime, $body, $img) {
      $this->name = $name;
      $this->datatime = $datatime;
      $this->body = $body;
      $this->img = $img;
    }

    public function printdate($name, $datatime, $body, $img) {

       echo $post['name'];
       echo $post['add_date'];
       echo $post['body'];
       print $post['img'];
       echo  "____________________________________";
    }


  }

?>
