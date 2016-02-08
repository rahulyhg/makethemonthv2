<?php
$question_info = $question['question'];
$answers_info = $question['answers'];
?>
<section class="question-ask" style="opacity:1">
    <div>
        <img src="<?php echo WEBSITE_URL.$question_info->icon;?>" alt="question-icon">
        <h2 class="white-text big"><?php echo $question_info->is_custom == 1?custom_question($lng == 'english'?$question_info->en_name:$question_info->fr_name,$lng == 'english'?$question_info->en_custom:$question_info->fr_custom):($lng == 'english'?$question_info->en_name:$question_info->fr_name); ?></h2>
        <h4 class="white-text bolder"><?php echo $this->lang->line('question-choose');?> </h4>
        <div class="answers-content">
            <?php
                $i = 0;
                foreach($answers_info as $answer){
                    $i++;
            ?>
            <div class="answer-box grey-class" data-answer="<?php echo $answer->id; ?>">
                <div>
                    <div class="number red-class button-circle"><h3 class="white-text bolder"><?php echo $i; ?></h3></div>
                    <h3 class="white-text"><?php echo replace_cost($lng == 'english'?$answer->en_desc:$answer->fr_desc, $answer->cost); ?></h3>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.answer-box').css('height',$('.answer-box').width()*0.8+"px");
        })
        $(window).load(function(){
            $('.answer-box').css('height',$('.answer-box').width()*0.8+"px");
        })
        $(window).resize(function(){
            $('.answer-box').css('height',$('.answer-box').width()*0.8+"px");
        })
    </script>
</section>
<?php
function replace_cost($string,$cost){
    if($cost>-1){
        $costS = '$'.$cost;
    }else{
        $stringC = explode('-',$cost);
        $costS = '-$'.$stringC[1];
    }
    return str_replace('{cost}','<br/>('.$costS.')',$string);
}
function custom_question($question,$variable = null){
    if(is_null($variable)){
        return $question;
    }
    $pos = strpos($variable,'{}');
    if($pos){
        $pos = strpos($question, '{custom}');
        if ($pos !== false){
            $i=0;
            $variables = explode('{}',$variable);
            while($pos){
                $question = preg_replace('/{custom}/',$variables[$i],$question,1);
                $i++;
                $pos = strpos($question, '{custom}');
            }
        }
    }else{
        $pos = strpos($question, '{custom}');
        if ($pos !== false){
            $question = str_replace('{custom}',$variable,$question);
        }
    }
    return $question;
}
?>