<?php

class ScoreboardView extends scoreboard
{

    // A public method that return all the scoreboard data from our protected class.
    public function scoreboardViewData(){
        return $this->getAllScoreBoardData();
    }
}