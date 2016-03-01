<?php

namespace Upload\GFileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Upload\GFileBundle\Entity\GFile\UploadFile;
use Upload\GFileBundle\Form\UploadType;

class DefaultController extends Controller {

    public function indexAction() {
        $entity = new UploadFile();
        $form = $this->createCreateForm($entity);

        return $this->render('UploadGFileBundle:Default:index.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    private function createCreateForm(UploadFile $entity) {
        $form = $this->createForm(new UploadType(), $entity, array(
            'action' => $this->generateUrl('upload_gfile_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Upload', 'attr' => array(
                'class' => 'btn btn-default',
        )));

        return $form;
    }

    public function createAction(Request $request) {
        $entity = new UploadFile();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $session = $this->getRequest()->getSession();
//        $data = $request->request->get('upload_gfilebundle_upload');
//        $name = $data['name'];
//        $email = $data['email'];
//        $data = $request->request->get('upload_gfilebundle_upload');
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $filename = $request->request->get('filename');
        $file = $request->request->get('file');
//        $file = $requestFile['file'];
        $sizeInBytes = 0;
        if (!$session->has('valbytes')) {

            $session->set('valbytes', $sizeInBytes);
            //dump($session);

            $entity->upload();
            
        } else {
            $name= explode("\\", $filename);
            $dirfile = '\\\seneca.local\\FS\\Groups\\IT\\UploadFile\\' . $name[2];
            if(file_exists($dirfile)){
            $sizeInBytes = filesize($dirfile);
            }
           ///dump($session);
           //dump($sizeInBytes);
        }
        //$filename=$entity->getFile()->getClientOriginalName();
        $totalsize = $entity->getFile()->getSize();

        // $entity->getFile()->move($entity->getUploadAbsolutePath(),$filename);
        //$entity->getFile()->getLinkTarget()
        // $entity->setFilename($filename);
        // $entity->setFile();
        //$dirfile='\\\seneca.local\\FS\\Groups\\IT\\UploadFile\\'.$filename;
        //$sizeInBytes = filesize($dirfile);
        // $fileup=$entity->getFile()->getClientSize();
        /* $nr=0; 
          $dirfile='\\\seneca.local\\FS\\Groups\\IT\\UploadFile\\'.$filename;
          if(file_exists($dirfile)){
          $nr=1;
          } */






        /*   $em = $this->getDoctrine()->getManager();
          $entity->setName($name);
          $entity->setEmail($email);
          $entity->setFilename($filename);
          $em->persist($entity);
          $em->flush();

          $message = \Swift_Message::newInstance()
          ->setSubject('Caricamento File')
          ->setFrom('brunaldo.toshkezi@xeniahs.com')
          ->setTo($entity->getEmail())
          ->setBody('Ciao,\n\n E stato caricato il file del utente ' . $name . '.', 'text/html');
          $this->get('mailer')->send($message); */

        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            $msgs = ['success' => true, 'message' => $sizeInBytes];
            $response->setData($sizeInBytes);
            return $response;
        } else {
            $this->get('session')->getFlashBag()->add('msg', 'Your file is uploaded!');
            return $this->redirect($this->generateUrl('upload_g_file_homepage'));
        }
    }

    public function uploadAction($data) {

        //$filename = $request->query->get('filename');
        // $file = $request->query->get('file');
        echo $data;
        exit();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

}
