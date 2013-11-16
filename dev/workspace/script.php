<?php
	include_once('workspace.php');
    //generate UI html
    function form($type, $arr){
        switch($type){
            case 'popup':
                return '<div class="dim"></div>
                <div class="cms_popup">
                    <div class="cms_popup_head">
                        <b style="font-size:1em;">'.$arr['title'].'</b>
                    </div>
                    <br /><br />
                    <div class="cms_popup_body">
                        '.$arr['desc'].'
                    </div>
                    <br /><br />
                    <button class="close">Close</button>
                </div>';
                break;
        }
    }
    //CSRF defense; end immediately and log
    if(isset($_REQUEST['token']) && $_REQUEST['token'] != $_SESSION['token']){
        die(Workspace::suspect('Invalid token.'));
    }
    $workspace = new Workspace();
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    //GET
    if(isset($_GET['signal'])){
        $g = $_GET;
        switch($g['signal']){
            case 'init':
                //check if they have already created a workspace
                die($workspace->workspace_exists());
                break;
            case 'popup':
                $workspace->verify_params($g, ['type']);
                $desc = '';
                switch($type){
                    case 'messages':
                        $desc .= '';
                        break;
                    case 'requests':
                        $desc .= '';
                        break;
                    case 'options':
                        $desc .= '';
                        break;
                    case 'current':
                        $desc .= '';
                        break;
                }
                die(form('popup', [
                    'title' => ucfirst($g['type']),
                    'desc' => $desc
                ]));
                break;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //POST (create)
    if(isset($_POST['signal'])){
        $p = $_POST;
        switch($p['signal']){
            case 'createWorkspace':
                $workspace->verify_params($p, ['name', 'category', 'description']);
                $workspace->create_workspace([
                    'name' => $p['name'],
                    'creator' => $_SESSION['ID'],
                    'date' => $workspace->getDate(),
                    'popularity' => 0,
                    'category' => $p['category'],
                    'description' => $p['description'],
                    'launched' => 0
                ]);
                break;
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //PUT (update)
    if(isset($_PUT['signal'])){
        $p = $_PUT;
        switch($p['signal']){

        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //DELETE
    if(isset($_DELETE['signal'])){
        $d = $_DELETE;
        switch($d['signal']){

        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////