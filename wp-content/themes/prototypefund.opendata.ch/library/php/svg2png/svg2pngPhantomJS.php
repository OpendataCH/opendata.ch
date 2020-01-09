<?php 

use JonnyW\PhantomJs\Client;

class svg2png {

  public function __construct(){

    $this->client = Client::getInstance();
    
    try {
      $this->client->getEngine()->setPath(PHANTOMJSBIN);
    } catch (Exception $e) {
      throw $e; 
    }
  }

  public function __destruct(){
  }

  public function generatePng ( $svgUrl , $pngName ) {

    $this->request  =  $this->client->getMessageFactory()->createRequest();
    $this->response =  $this->client->getMessageFactory()->createResponse();

    $html = $this->preparePage($svgUrl);
    $htmlFile = sys_get_temp_dir() . '/' .  basename($svgUrl,'.svg') . '.html';

    file_put_contents( $htmlFile , $html );

    $this->request =  $this->client->getMessageFactory()->createCaptureRequest('file://' . $htmlFile , 'GET');
    
    $this->request->setFormat('png');
    $this->request->setOutputFile($pngName);
    $this->response =  $this->client->getMessageFactory()->createResponse();
    $this->client->send($this->request, $this->response);

    unlink($htmlFile);

    return $pngName;
  }

  public function deletePng ($pngName ) {
    unlink( $pngName);
    return true;
  }

  protected function preparePage ($svg) {

    $m = new Mustache_Engine(array(
      'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views')
      ));

    $tpl = $m->loadTemplate('template');
    return $tpl->render(array('file' => $svg));

  }

}

?>