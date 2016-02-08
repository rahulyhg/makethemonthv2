<section class="question-answer" style="opacity:1" >
    <div>
        <div class="consequence-box grey-class">
            <h4 class="small white-text bolder"><?php echo $this->lang->line('answer-impact');?></h4>
            <h2 class="big white-text"><?php 
            $result = $lng == 'english'?$answer->en_result:$answer->fr_result; 
            if(strpos($result, '{cost}')){
                $result = str_replace('{cost}',$answer->cost,$result);
            }
            echo replace_cost($result,$answer->cost,$answer->extra_cost);
            ?></h2>
            <?php
            $result = $lng == 'english'?@$answer->en_supporting_facts:@$answer->fr_supporting_facts;
            if($result){ ?>
            <hr>
            <h4 class="small white-text bolder"><?php echo $this->lang->line('fact');?></h4>
            <h4 class="small white-text"><?php
            echo replace_cost($result,$answer->cost,$answer->extra_cost);
            ?></h4>
            <?php } ?>
            <div class="button-answer red-class" id="go-questions"><h3 class="white-text bolder"><?php echo $this->lang->line('next-button');?></h3></div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var boxHeight = 0.8;
            var paddingBox = 2.2;
            var windowHeight = $(window).height();
            if(windowHeight < 1080){
                boxHeight = 0.7;
                paddingBox =1.7;
            }
            if(windowHeight < 768){
                paddingBox = 1.5;
            }
            if(windowHeight < 641){
                paddingBox=1.3;
            }
            $('.consequence-box').css('min-height',$(window).height()*boxHeight+"px");
            if($(window).width()>720){
                $('.consequence-box').css('width',$('.consequence-box').height()*paddingBox);
            }
        })
        $(window).resize(function(){
            var boxHeight = 0.8;
            var paddingBox = 2.2;
            var windowHeight = $(window).height();
            if(windowHeight < 1080){
                boxHeight = 0.7;
                paddingBox =1.7;
            }
            if(windowHeight < 768){
                paddingBox = 1.5;
            }
            if(windowHeight < 641){
                paddingBox=1.3;
            }
            $('.consequence-box').css('min-height',$(window).height()*boxHeight+"px");
            if($(window).width()>720){
                $('.consequence-box').css('width',$('.consequence-box').height()*paddingBox);
            }
        });
    </script>
</section>
<?php
function replace_cost($string,$cost,$extra = null){
    if($cost>-1){
        $costS = '$'.$cost;
    }else{
        $stringC = explode('-',$cost);
        $costS = '-$'.$stringC[0];
    }
    if(!is_null($extra)){
        if($extra >-1){
            $extraS = '$'.$extra;
        }else{
            $stringC = explode('-',$extra);
            $extraS = '-$'.$stringC[1];
        }
    }else{
        return str_replace('{cost}',$costS,$string);
    }
    $newString = str_replace('{cost}',$costS,$string);
    $newString = str_replace('{extracost}',$extraS,$newString);
    $newString = str_replace('{extra cost}',$extraS,$newString);
    return str_replace('{extrafee}',$extraS,$newString);
}
?>