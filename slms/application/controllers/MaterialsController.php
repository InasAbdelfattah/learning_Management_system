<?php

class MaterialsController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_Materials;
        # send loged in user data
        $this->user_model = new Application_Model_Users();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        if ($this->auth) {
            $this->user_model->id = $this->auth->id;
            $currunt_user = $this->user_model->getUser();
            if ($currunt_user[0]['is_active'] == 1)
                $layout->user = $currunt_user;
            else
                $this->redirect('user/login');
        }
        else
                $this->redirect('user/login');
    }

    public function indexAction() {
        // action body
        $course_id = $this->getRequest()->getParam('course_id');
        $material_type_id = $this->getRequest()->getParam('material_type_id');
        #select materials where material_type_id=$material_type_id && course_id=$course_id
        $materials = $this->model->fetchAll($this->model->select('*')->where('material_type_id =?', $material_type_id)->where('course_id=?', $course_id))->toArray();
        #$this->view->materials = $this->model->listMaterials();
        $this->view->materials = $materials;

    }

    public function downloadAction() {
        $material_id = $this->getRequest()->getParam('material_id');
        $file = $this->model->fetchAll($this->model->select('*')->where('id =?', $material_id))->toArray();
        $path = $file[0]['path'];
        // disable view and layout 
        Zend_Layout::getMvcInstance()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        //set mimetype (content-type image/jpeg etc)
        $mtype = '';

        // magic_mime module installed?
        if (function_exists('mime_content_type')) {
            $mtype = mime_content_type($path);
        }
        // fileinfo module installed?
        else if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME); // return mime type
            $mtype = finfo_file($finfo, $path);
            finfo_close($finfo);
        }
        // set headers 
        header("Content-Type: " . $mtype);
        header('Content-Disposition: attachment; filename=' . $path);
        #readfile($path);
    }

    public function viewAction() {
        $material_id = $this->getRequest()->getParam('material_id');
        $file = $this->model->fetchAll($this->model->select('*')->where('id =?', $material_id))->toArray();
        /*$this->model->id=$material_id;
        $file=$this->model->getMaterial();*/
        $fpath = $file[0]['path'];
        $this->view->path=$fpath;
        $path='materials_upload_folder/'.$fpath ;
        #handle video view
        $ext=strtolower(end(explode(".",$fpath)));
        $this->view->ext=$ext;
        $this->view->vpath=$path;
        /*if (in_array($ext, $video )) {
                #$this->redirect('materials/download/material_id/'.$material_id);
            $this->view->vpath=$path;
            $this->render('try');}
        /*}elseif (strtolower(end(explode(".",$fpath)))=='com') {
            # code...
        }*/

        #else{*/

        // disable view and layout 
        Zend_Layout::getMvcInstance()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $mtype = '';

        // magic_mime module installed?
        if (function_exists('mime_content_type')) {
            $mtype = mime_content_type($path);
        }
       
        // fileinfo module installed?
        else if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME); // return mime type
            $mtype = finfo_file($finfo, $path);
            finfo_close($finfo);
        }

        $rare=array('application/zip','application/x-rar-compressed',);
        #$video=array('video/quicktime','video/quicktime',);
        if (in_array($mtype, $rare )) {
                $this->redirect('materials/download/material_id/'.$material_id);
        }
        /*elseif (in_array($mtype, $video )) {
                # code...
            }*/ 
        else{
            // set headers 
            header("Content-Type: " . $mtype);

            // Open the file for reading
            $fh = fopen($path, 'r');

            // And pass it through to the browser
            fpassthru($fh);
        }    
    }
}
#}
?>
