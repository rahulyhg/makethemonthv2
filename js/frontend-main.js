var clock,
    budget,
    rent,
    end;
var start = 0;
var options = {
    useEasing : true,
    useGrouping : true,
    separator : ','
};
var player = {};
var stats = {
    final:false,
    day:{}
};
var windowPadding = 80;
$(window).load(function(){
    var windowHeight = $(window).height();
    if(windowHeight < 1080){
        windowPadding = 50;
    }
    if(windowHeight < 768){
        windowPadding = 30;
    }
    if(windowHeight<900 && $(window).width()<500){
        windowPadding = 10;
    }
});
$(document).on('click','.select-custom [data-show]',function(){
    $('.select-options').toggleClass('open');
    $(this).toggleClass('open');
    if($('.select-options').hasClass('open')){
        $('.nicescroll-cursors').fadeIn(500);
    }else{
        $('.nicescroll-cursors').fadeOut(500);
    }
    setTimeout(function(){
        $(".select-options").getNiceScroll().resize();
    },1000);
});
$(document).on('click','.select-custom [data-city]',function(){
    $('.nicescroll-cursors').fadeOut(500);
    $('.select-custom [data-show] span').text($(this).text());
    $('.select-custom [data-action]').attr('onclick','window.location.replace("'+site_url+$(this).attr('data-city')+'")');
    $('.select-options').removeClass('open');
    $('.select-custom [data-show]').removeClass('open');
});
$(document).on('change','.mobile-select',function(){
    $('.select-custom [data-action]').attr('onclick','window.location.replace("'+site_url+$(this).val()+'")');
});
$(window).load(function(){
    $('body').fadeIn(1500);
    $('.content').css('height',$(window).height()-$('footer').height()-windowPadding+'px');
    $('body').removeClass('mobile-version');
    $('nav').css('height',$(window).height());
    $('.has-menu footer, .has-menu section').css('width',$(window).width()-$('nav').width()+'px');
    mobile_resize();
});
$(window).resize(function(){
    $('.content').css('height',$(window).height()-$('footer').height()-windowPadding+'px');
    $('body').removeClass('mobile-version');
    $('nav').css('height',$(window).height());
    $('.has-menu footer, .has-menu section').css('width',$(window).width()-$('nav').width()-5+'px');
    mobile_resize();
});
var scenario;
$(document).on('click','[data-step="scenario"]',function(){
    player.lang = $(this).attr('data-lang');
    $('body').fadeOut(1000);
    stats.city = city_id;
    stats.id = playerId;
    loading_bg();
    $.ajax({
        url:site_url+'ajax/get_scenario_scene',
        type:"POST",
        data:{'id':q_id,lang:player.lang},
        success:function(response){
            scenario = JSON.parse(response);
            $('body').addClass('has-transition').removeClass('red-class').addClass(scenario.body);
            $('section').fadeOut(500);
            $('footer').addClass('grey').html(scenario.footer);
            player.city = scenario.city;
            if($(window).width()<720){
                $('nav ul').html(scenario.menu_mobile);
            }else{
                $('nav ul').html(scenario.menu_content);
            }
            clock = $('.days-status').FlipClock(1, {
                clockFace: 'Counter'
            });
            setTimeout(function(){
                $('.content').html(scenario.content);                
                $('body').fadeIn(1000);
                $('section').css('opacity','1');
                $('footer').fadeIn(1000);
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    })
});
$(document).on('click','.scenario [data-id]',function(){
    if($(this).hasClass('disabled')){
        return false;
    }
    $('[data-id]').addClass('disabled');
    $('body').fadeOut(1000);
    loading_bg();
    player.scenario = scenario.data[$(this).index()];
    stats.scenario = player.scenario.id;
    $.ajax({
        url:site_url+'ajax/get_scenario',
        type:"POST",
        data:{'scenario':player.scenario.id, lang:player.lang, city:city_id,stats:stats},
        success:function(response){
            var result = JSON.parse(response);
            $('body').removeClass('dark-class').addClass(result.body);
            $('section').fadeOut(500);
            setTimeout(function(){
                $('.content').html(result.content); 
                $('body').addClass('has-menu');
                $('.has-menu footer, .has-menu section').css('transition','none').css('width',$(window).width()-$('nav').width()-5+'px').css('transition','');
                $('nav').css('height',$(window).height());
                $('body').fadeIn(1000);
                $('section').css('opacity','1');
                end = player.scenario.start_up;
                budget = new countUp("remain_buget_counter", 0, end, 0, 3, options);
                budget.start();
                start = end;
                mobile_resize();
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    })
});
var total_questions = {};
$(document).on('click','#rent-scene',function(){
    loading_bg();
    $.ajax({
        url:site_url+'ajax/get_rent',
        type:"POST",
        data:{'scenario':player.scenario.id, lang:player.lang, city: player.city.q_id},
        success:function(response){
            var rent = JSON.parse(response);
            $('section').fadeOut(500);
            total_questions = rent.question_ids;
            setTimeout(function(){
                $('.content').html(rent.content);
                $('.has-menu footer, .has-menu section').css('transition','none').css('width',$(window).width()-$('nav').width()-5+'px').css('transition','');
                $('section').css('opacity','1');
                mobile_resize();
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    })
});
var used_question = [];
var current_question;
var end_game = [];
var current_answer = {};
current_answer.show_help = 0;
var strike_value = 0;
var day;
$(document).on('click','#go-questions',function(){
    if($(this).hasClass('disabled')){
        return false;
    }
    loading_bg();
    $(this).addClass('disabled');
    end = start - rent;
    if(rent > 0){
        budget_animation(-5);
        stats.rent = rent;
    }else{
        clock.increment();
        $('.payday-status').text(parseInt($('.payday-status').text())-1);
        day  = clock.getTime();
        if(day == 30){
            win_game();
            return false;
        }
        if(day == 15){
            end = end + parseInt(player.scenario.salary);
            payday();
            $('.payday-status').text(15);
            budget = new countUp("remain_buget_counter", start, end, 0, 3, options);
            budget.start();
            start = end;
        }
    }
    rent = 0;
    budget = new countUp("remain_buget_counter", start, end, 0, 3, options);
    budget.start();
    start = end;
    if(end < 0){
        lose_game();
        return false;
    }else{
        if(parseInt(current_answer.show_help) == 1){
            $.ajax({
                url:site_url+'ajax/get_donate',
                type:"POST",
                data:{lang:player.lang,city: player.city.q_id, id:current_answer.id,stats:stats},
                success:function(response){
                    var result = JSON.parse(response);
                    $('section').fadeOut(500);
                    setTimeout(function(){
                        $('.content').html(result.content);
                        $('body').removeClass('white-class').addClass(result.body);
                        $('.has-menu section').css('transition','none').css('width',$(window).width()-$('nav').width()+'px').css('transition','');
                        $('section').css('opacity','1');
                        mobile_resize();
                        setTimeout(function(){
                            done_loading();
                        },100);
                    },500);
                }
            })
        }else{
            var first_question = Math.floor(Math.random() * total_questions.length);
            used_question.push(total_questions[first_question]);
            day  = clock.getTime();
            stats.day[day] = {};
            stats.day[day].question = total_questions[first_question];
            $.ajax({
                url:site_url+'ajax/get_question',
                type:"POST",
                data:{'scenario':player.scenario.id, lang:player.lang, city: player.city.q_id, id:total_questions[first_question], not_id:used_question,stats:stats},
                success:function(response){
                    var result = JSON.parse(response);
                    $('section').fadeOut(500);
                    current_question = result.question;
                    setTimeout(function(){
                        $('.content').html(result.content);
                        $('section').css('opacity','1');
                        mobile_resize();
                        setTimeout(function(){
                            done_loading();
                        },100);
                    },500);
                }
            })
        }
    }
});
$(document).on('click','[data-answer]',function(){
    if($(this).hasClass('disabled')){
        return false;
    }
    $('[data-answer]').addClass('disabled');
    loading_bg();
    current_answer = current_question.answers[$(this).index()];
    day = clock.getTime();
    stats.day[day].answer = current_answer.id;
    if(current_answer.en_end_game){
        end_game.push(current_answer[player.lang+'_end_game'])
    }
    var cost;
    if(parseInt(current_answer.cost)){
        cost = parseInt(current_answer.cost);
    }else{
        cost = 0;
    }
    if(parseInt(current_answer.extra_cost)){
        cost+=parseInt(current_answer.extra_cost);
    }
    end = start + cost;
    stress(parseInt(current_answer.stress)-1);
    strike_value+=parseInt(current_answer.strike);
    strike_function(strike_value);
    if(parseInt(current_answer.bills) > 0){
        deferred_function(current_answer.bills,'bill');
    }
    if(parseInt(current_answer.car) > 0){
        deferred_function(current_answer.car,'car');
    }
    if(parseInt(current_answer.credit) > 0){
        deferred_function(current_answer.credit,'credit');
    }
    if(end < 0){
        $('#remain_buget_counter').addClass('red-text');
        budget_animation(-10);
    }else{
        if(parseInt(current_answer.cost) > 0){
            budget_animation(1);
        }else{
            if(parseInt(current_answer.cost) < 0){                
                budget_animation(-1);
            }
        }
    }
    budget = new countUp("remain_buget_counter", start, end, 0, 3, options);
    budget.start();
    start = end;
    $.ajax({
        url:site_url+'ajax/get_answer',
        type:"POST",
        data:{'scenario':player.scenario.id, lang:player.lang, city: player.city.q_id, not_id:used_question, id:current_answer.id, stats:stats},
        success:function(response){
            var result = JSON.parse(response);
            $('section').fadeOut(500);
            total_questions = result.question_ids;
            setTimeout(function(){
                $('.content').html(result.content);
                $('body').removeClass('white-class').addClass(result.body);
                $('.has-menu section').css('transition','none').css('width',$(window).width()-$('nav').width()+'px').css('transition','');
                $('section').css('opacity','1');
                mobile_resize();
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    });
});
$(document).on('click','[data-answer-go]',function(){
    loading_bg();
    var first_question = Math.floor(Math.random() * total_questions.length);
    used_question.push(total_questions[first_question]);
    day  = clock.getTime();
    stats.day[day] = {};
    stats.day[day].question = total_questions[first_question];
    $.ajax({
        url:site_url+'ajax/get_question',
        type:"POST",
        data:{'scenario':player.scenario.id, lang:player.lang, city: player.city.q_id, id:total_questions[first_question], not_id:used_question, stats:stats},
        success:function(response){
            var result = JSON.parse(response);
            $('section').fadeOut(500);
            current_question = result.question;
            setTimeout(function(){
                $('.content').html(result.content);
                $('section').css('opacity','1');
                $('body').removeClass('white-class').addClass(result.body);
                mobile_resize();
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    })
});
$(document).on('click','#privacy',function(){
    loading_bg();
    if(player && player.lang){
        lang = player.lang;
    }
    $.ajax({
        url:site_url+'ajax/get_privacy',
        type:"POST",
        success:function(response){
            var result = JSON.parse(response);
            $('.pop-up-container > h2').text(result.title);
            if(lang == "en"  || lang != "french"){
                $('.pop-up-container > .pop-up-content').html(result.document);
            }else{
                $('.pop-up-container > .pop-up-content').html(result.fr_document);
            }
            $('.overlay').fadeIn(500);
            setTimeout(function(){
                done_loading();
            },100);
        }
    })
});
$(document).on('click','#about-us',function(){
    loading_bg();
    if(player && player.lang){
        lang = player.lang;
    }
    $.ajax({
        url:site_url+'ajax/get_about',
        type:"POST",
        success:function(response){
            var result = JSON.parse(response);
            $('.pop-up-container > h2').text(result.title);
            if(lang == "en"  || lang != "french"){
                $('.pop-up-container > .pop-up-content').html(result.document);
            }else{
                $('.pop-up-container > .pop-up-content').html(result.fr_document);
            }
            $('.overlay').fadeIn(500);
            setTimeout(function(){
                done_loading();
            },100);
        }
    })
});
$(document).on('click','#emailshare',function(){
    loading_bg();
    if(player && player.lang){
        lang = player.lang;
    }
    $.ajax({
        url:site_url+'ajax/get_email_template',
        type:"POST",
        data:{lang:lang},
        success:function(response){
            var result = JSON.parse(response);
            $('.pop-up-container > h2').text(result.title);
            $('.pop-up-container > .pop-up-content').html(result.content);
            $('.pop-up').addClass('email-template').removeClass('take-action');
            $('.overlay').fadeIn(500);
            $('.pop-up-content').niceScroll({cursoropacitymin:0.7,cursorwidth:10});
            setTimeout(function(){
                done_loading();
            },100);
        }
    })
});
$(document).on('keyup','[name="names[]"], [name="emails[]"]',function(){
    var li = $(this).parent('li');
    var cond = true;
    $(li).find('input').each(function(){
        if($(this).val() == ""){
            cond = false;
        }
    });
    if(cond){
        if($(li).hasClass('current')){
            $(li).removeClass('current');
            $(li).parent('ul').append('<li class="current"><input type="text" name="names[]" placeholder="Friend name"><input type="email" name="emails[]" placeholder="Friend email"></li>');
            $(".pop-up-content").getNiceScroll().resize();
        }
    }
});
$(document).on('submit','#share-emails',function(e){
    e.preventDefault();
    loading_bg();
    var data = [];
    $('.invite-friends li').each(function(){
        if(($(this).find('[name="names[]"]').val() && !$(this).find('[name="emails[]"]').val()) ||(!$(this).find('[name="names[]"]').val() && $(this).find('[emails="names[]"]').val())){
            $(this).find('input').css('border-color','red');
            return false;
        }else{
            $(this).find('input').css('border-color','');
            if($(this).find('[name="names[]"]').val() && $(this).find('[name="emails[]"]').val()){
                var info = {
                    name:$(this).find('[name="names[]"]').val(),
                    email:$(this).find('[name="emails[]"]').val()
                };
                data.push(info);
            }
        }
    });
    var day;
    if(!clock){
        day = 0;
    }else{
        day = clock.time.time;
    }
    if(player && player.lang){
        lang = player.lang;
    }
    $.ajax({
        url:site_url+'ajax/send_share',
        type:"POST",
        data:{info:data,name:$('[name="name"]').val(),email:$('[name="email"]').val(),daysx:day, lang:lang},
        success:function(response){
            var result = JSON.parse(response);
            $('.pop-up-container > h2').text(result.title);
            $('.pop-up').removeClass('email-template').addClass('email-result');
            $('.overlay').fadeIn(500);
            setTimeout(function(){
                done_loading();
            },100);
        }
    })
});
$(document).on('click','#take-action',function(){
    loading_bg();
    if(player && player.lang){
        lang = player.lang;
    }
    $.ajax({
        url:site_url+'ajax/get_take_action',
        type:"POST",
        data:{lang:lang,city:q_id},
        success:function(response){
            var result = JSON.parse(response);
            $('.pop-up-container > h2').text(result.title);
            $('.pop-up').addClass('take-action').removeClass('email-template');
            $('.pop-up-container > .pop-up-content').html(result.content);
            $('.overlay').fadeIn(500);
            setTimeout(function(){
                done_loading();
            },100);
        }
    })
});
$(document).on('click','.close-pop-up',function(){
    $('.overlay').fadeOut(500);
    setTimeout(function(){
        $('.pop-up').removeClass('email-template').removeClass('email-result').removeClass('take-action');
    },600);
});
function mobile_resize(){
    if($(window).width()<720){
        $('nav').css('height',"");
        $('.content').css('height',$(window).height()-$('footer').height() - $('nav').height()-10);
        $('footer').css('width','100%');
    }else{
        $('.content').css('height',$(window).height()-$('footer').height()-windowPadding+'px');
    }
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function budget_animation(value){
    if(value == 1){
        $('.red-buget').css({height:"-=2%","min-height":0});
        if($('.red-buget').height()<1){
            $('.red-buget').css('height',"0%");
        }
    }else if(value == -1){
        $('.red-buget').css({height:"+=2%","max-height":"100%"});
        if($('.red-buget').height()>$('.light-buget').height()){
            $('.red-buget').css('height',$('.light-buget').height());
        }
    }else if(value == -10){
        $('.red-buget').css({height:"100%","max-height":"100%"});
    }else if(value == 10){
        $('.red-buget').css({height:"0"})
    }else{
        $('.red-buget').css({height:"50%","max-height":"100%"})
    }
}
function stress(value){
    $('#stress-level').attr('src',site_url+'uploads/strees_'+value+'.png');
}
function strike_function(value){
    for(var i=1; i<=value;i++){
        $('#strike_'+i+' line').attr('stroke','#ffffff');
        $('#strike_'+i+' circle').attr('fill','#d7281e');
        $('#strike_'+i).css('box-shadow','0 0 10px #d7281e');
    }
}
function deferred_function(value,mode){
    if(value == 1){
        $('#'+mode+'-def path').attr('fill','#ffffff');
        $('#'+mode+'-def polygon').attr('fill','#ffffff');
        $('#'+mode+'-def circle').attr('fill','#d7281e');
        $('#'+mode+'-def').css('box-shadow','0 0 10px #d7281e');
    }else{
        $('#'+mode+'-def path').attr('fill','#282828');
        $('#'+mode+'-def polygon').attr('fill','#282828');
        $('#'+mode+'-def circle').attr('fill','#4D4D4D');
        $('#'+mode+'-def').css('box-shadow','');
    }
}
function payday(){
    budget_animation(-10);
    $('.payday-loader').fadeIn('slow');
    $('.payday-loader .buget-animate div').addClass('animate-me');
    budget_animation(10);
    setTimeout(function(){
        $('.payday-loader').fadeOut('slow');
    },2500)
}
function win_game(){
    loading_bg();
    stats.final = true;
    stats.end = "win";
    $.ajax({
        url:site_url+'ajax/get_win',
        type:"POST",
        data:{lang:player.lang, end_con:end_game,city:player.city.q_id, stats:stats},
        success:function(response){
            var result = JSON.parse(response);
            $('section').fadeOut(500);
            setTimeout(function(){
                $('.content').html(result.content); 
                $('section').css('opacity','1');
                mobile_resize();
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    })
}
function lose_game(){
    loading_bg();
    stats.final = true;
    stats.end = "lose";
    $.ajax({
        url:site_url+'ajax/get_lose',
        type:"POST",
        data:{lang:player.lang, end_con:end_game,city:player.city.q_id, stats:stats},
        success:function(response){
            var result = JSON.parse(response);
            $('section').fadeOut(500);
            setTimeout(function(){
                $('.content').html(result.content); 
                $('section').css('opacity','1');
                mobile_resize();
                setTimeout(function(){
                    done_loading();
                },100);
            },500);
        }
    })
}
(function() {
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1467425443559194',
            xfbml      : true,
            version    : 'v2.4'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    var fbShare = function() {
        var description = "";
        if(clock){
            if(player.lang == "fr" || lang == "french"){
                description = "Je viens de jouer makethemonth.ca et j'ai atteint le "+clock.getTime()+" jour du mois. Pouvez vous #makethemonth?";
            }else{
                description = "I just played MakeTheMonth.ca and made it to day "+clock.getTime()+". Can you #makethemonth?";
            }
        }else{
            if(player.lang == "fr" || lang == "french"){
                description = "Je viens de jouer MakeTheMonth.ca. Pouvez vous #makethemonth?";
            }else{
                description = "I just played MakeTheMonth.ca can you #makethemonth?";
            }
        }
        FB.ui({
            method: "feed",
            display: "iframe",
            link: site_url,
            caption: "MakeTheMonth.ca",
            description: description,
            picture: "http://makethemonth.ca/images/Make-The-Month.gif"
        });
    };
    $(document).on('click',"#facebookshare",function() {
        FB.login(function(response) {
            if (response.authResponse) {
                fbShare();
            }
        }, {scope: 'publish_actions'});
    });
    $(document).on('click',"#linkedinshare",function() {
        var description = "";
        console.log(lang);
        if(clock){
            if(player.lang == "fr" || lang == "french"){
                description = "Je viens de jouer makethemonth.ca et j'ai atteint le "+clock.getTime()+" jour du mois. Pouvez vous #makethemonth?";
            }else{
                description = "I just played MakeTheMonth.ca and made it to day "+clock.getTime()+". Can you #makethemonth?";
            }
        }else{
            if(player.lang == "fr" || lang == "french"){
                description = "Je viens de jouer MakeTheMonth.ca. Pouvez vous #makethemonth?";
            }else{
                description = "I just played MakeTheMonth.ca can you #makethemonth?";
            }
        }
        var articleUrl = encodeURIComponent(site_url);
        var articleTitle = encodeURIComponent('MakeTheMonth.ca');
        var articleSummary = encodeURIComponent(description);
        var articleSource = encodeURIComponent('MakeTheMonth.ca');
        var goto = 'http://www.linkedin.com/shareArticle?mini=true'+
            '&url='+articleUrl+
            '&title='+articleTitle+
            '&summary='+articleSummary+
            '&source='+articleSource;
        window.open(goto, "LinkedIn", "width=660,height=400,scrollbars=no;resizable=no");
        return false;
    });
    $(document).on('click',"#twitttershare",function() {
        var description = "";
        if(clock){
            if(player.lang == "fr" || lang == "french"){
                description = "Je viens de jouer makethemonth.ca et j'ai atteint le "+clock.getTime()+" jour du mois. Pouvez vous #makethemonth?";
            }else{
                description = "I just played MakeTheMonth.ca and made it to day "+clock.getTime()+". Can you #makethemonth?";
            }
        }else{
            if(player.lang == "fr" || lang == "french"){
                description = "Je viens de jouer MakeTheMonth.ca. Pouvez vous #makethemonth?";
            }else{
                description = "I just played MakeTheMonth.ca can you #makethemonth?";
            }
        }
        var articleUrl = encodeURIComponent(site_url);
        var articleSummary = encodeURIComponent(description);
        var goto = 'https://twitter.com/intent/tweet?'+
            '&url='+articleUrl+
            '&text='+articleSummary;
        window.open(goto, "LinkedIn", "width=660,height=400,scrollbars=no;resizable=no");
        return false;
    })
})();
$(document).on('click','.mobile-footer img,.mobile-footer li',function(){
    $('.mobile-footer ul').toggleClass('open');
});
$(document).mouseup(function (e){
    var container = $(".mobile-footer ul");
    if (!container.is(e.target) && container.has(e.target).length === 0){
        $('.mobile-footer ul').removeClass('open');
    }
});
function loading_bg(){
}
function done_loading(){
}