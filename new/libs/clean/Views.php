<?php
/*
Notes -
Views will be used for suggestions
Actions will be used for lounge
*/
//class for keeping track of views on certain things
class Views{
    const LIMIT = 20; //number of views to scan through
    const AMNT = 1; //amount of suggestions for each view that we have (we parse by `what`)
    //things you can view ($what): thread, project, profile
    //session has now seen this $id
    //$id is id of project, thread, or profile (member) maps with `assoc`
    //$category is any category we need to associate with eg general discussion
    public static function view($id, $what, $category = 'none'){
        //we will only store unique vies by each user
        if(!self::hasSeen($id, $what)){
            Database::getInstance()->query("INSERT INTO `views` (`assoc`, `what`, `date`, `by`, `category`) 
            VALUES (?, ?, ?, ?, ?)", $id, $what, date("Y-m-d H:i:s"), $_SESSION['ID'], $category);
        }
    }
    //has session seen this $id
    private function hasSeen($id, $what){
        //we have seen it if the amount of views on it from this session does not equal 0
        return Database::getInstance()->query("SELECT COUNT(*) FROM `views` WHERE 
        `assoc` = ? AND `what` = ? AND `by` = ?", $id, $what, $_SESSION['ID'])->fetchColumn() != 0;
    }
    //get number of people who have viewed this ID
    public static function numViews($id, $what){
        return Database::getInstance()->query("SELECT COUNT(*) FROM `views` WHERE `assoc` = ? AND `what` = ?", $id, $what)->fetchColumn();
    }
    //get all information from recent views by this session (used for suggestions, so exclude profile)
    public static function sessionViews(){
        return Database::getInstance()->query("SELECT * FROM `views` WHERE `by` = ? AND `what` != ? ORDER BY `date` DESC LIMIT ".self::LIMIT, $_SESSION['ID'], 'profile');
    }
    //we can either make suggestions to see a project or a thread
    //we have to suggest something that they havent seen before
    //but also something that will be interesting to them
    //so we sort by the `what` parameter of the `views` table
    //make a suggestion based on views
    public static function makeSuggestion(){
        $suggestions = []; //array of suggestions
        while($row = self::sessionViews()->fetch()){
            //first level of difference is what type of thing we're even dealing with
            $what = $row['what'];
            if($what == 'project'){
                //now find some projects in this same category ranked by popularity
                array_push($suggestions, Database::getInstance()->query("SELECT * FROM `projects` WHERE `launched` = ? AND `category` = ? 
                    ORDER BY `popularity` LIMIT ".self::AMNT, 1, $row['category']));
            }else if($what == 'thread'){
                //now find some threads in this same category ranked by views
                array_push($suggestions, Database::getInstance()->query());
            }
        }
        return $suggestions;
    }
}