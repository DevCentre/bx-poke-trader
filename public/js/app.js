// init variables
$(document).ready(function() {
    pageOffset = 12;
    $('[data-toggle="tooltip"]').tooltip();
    isActive = false;
    ashListXP = 0;
    teamRocketListXP = 0;
    fair=0;
    introJs().start();
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Add more content on scroll
function AddMoreContent() {
    $.get('/getDataPokedex/'+pageOffset+'/0', function(data) {
      $(data).each(function(i){
        pokeName = data[i].poke_name;
        pokeNumber = (data[i].pokeURL).split('/')[6];
        pokeHP = data[i].HP;
        pokeXP = data[i].base_experience;
        content =
        `<div class="col-md-3">
              <div class="pokemon panel panel-primary">
                  <div class="panel-heading">
                      <h1>
                          ` + pokeName.toUpperCase() + `
                          <span class="label label-primary pull-right"># ` + pokeNumber + ` </span>
                      </h1>
                  </div>
                  <div class="panel-body">
                  <a onclick="addPokeTrade('`+pokeName+`','`+pokeXP+`','.ashPanel')"><img data-toggle="tooltip" title="Add in Ash trade!" class='ashImage' src='img/pokeball_2.png' style='width:35px;position:sticky;' /></a>
                  <a onclick="addPokeTrade('`+pokeName+`','`+pokeXP+`','.rocketTeamPanel')"><img data-toggle="tooltip" title="Add in Team Rocket trade!" class='teamRocketImage pull-right' src='img/teamrocket_ball.png' style='width:32px;position:sticky;' /></a>
                      <a >
                          <img class="avatar center-block" src="img/pokemons/`+pokeName+`.png">
                      </a>
                  </div>
                  <div class="panel-footer">
                      <span style='font-size:0.9em'><i class="fa fa-heartbeat"></i> HP: `+pokeHP+`</span>
                      <span style='font-size:0.9em' class='pull-right'><i class="fa fa-fist-raised"></i> XP: `+pokeXP+`</span>
                      <div class="text-center">`;
        $(data[i].types).each(function(j){

          content += `<a>
                        <span class="label type type-`+data[i].types[j]+`">
                            `+data[i].types[j]+`
                        </span>
                      </a>`;
        });

        content += `</div>
                  </div>
              </div>
          </div>`;

          $(content).insertBefore($('#moreContent'));
      });
    });
    isActive = false;
    // $('.loadingContent').hide();
    pageOffset+=12;
    $('[data-toggle="tooltip"]').tooltip();
}

//color pokeballs as it is added or removed from trade list
function colorPokeballs(destiny){
  if(destiny=='.ashPanel'){
    for(let i=0;i<=6;i++){
      $('.ashPokeball'+i).css('color','');
    }
    for(let i=0;i<ashTradeList.length;i++){
      $('.ashPokeball'+i).css('color','red');
    }
  }else{
    for(let i=0;i<=6;i++){
      $('.teamRocketPokeball'+i).css('color','');
    }
    for(let i=0;i<teamRocketTradeList.length;i++){
      $('.teamRocketPokeball'+i).css('color','red');
    }
  }
}

//add pokemon to tradelist
ashTradeList=[];
teamRocketTradeList=[];
function addPokeTrade(pokeName,pokeXP,destiny){
  if(destiny=='.ashPanel'){
    if(ashTradeList.length > 5){
      Swal.fire({
        icon:'warning',
        title:"You can't add any more pokemon to Ash trade",
        text:"Remove one or more to add another pokemon",
      });
    }else{
      ashTradeList.push({pokeName,pokeXP});
      addedSuccess(destiny);
    }
  }else{
    if(teamRocketTradeList.length > 5){
      Swal.fire({
        icon:'warning',
        title:"You can't add any more pokemon to Team Rocket trade",
        text:"Remove one or more to add another pokemon",
      });
    }else{
      teamRocketTradeList.push({pokeName,pokeXP});
      addedSuccess(destiny);
    }
  }
}

//Build trade list items
function buildTradeList(destiny){
  if(destiny=='.ashPanel'){
    for(let i=0;i<=5;i++){
      $(destiny+i+" .panel-body img").remove();
      $(destiny+i+" span").remove();
    }
    $(ashTradeList).each(function(i){
      $(destiny+i).prepend(`<span class='badge pull-right pointerHand' onclick='removePokeTrade(".ashPanel",`+i+`)'><i class='fa fa-times'></i></span>`);
      $(destiny+i+' .panel-body').prepend(`<img src="img/pokemons/`+ashTradeList[i].pokeName+`.png" />`);
    });
  }else{
    for(let i=0;i<=5;i++){
      $(destiny+i+" .panel-body img").remove();
      $(destiny+i+" span").remove();
    }
    $(teamRocketTradeList).each(function(i){
      $(destiny+i).prepend(`<span class='badge pull-right pointerHand' onclick='removePokeTrade(".rocketTeamPanel",`+i+`)'><i class='fa fa-times'></i></span>`);
      $(destiny+i+' .panel-body').prepend(`<img src="img/pokemons/`+teamRocketTradeList[i].pokeName+`.png" />`);
    });
  }
}

function addedSuccess(destiny){
  buildTradeList(destiny);
  colorPokeballs(destiny);
  calculateTrade();
  Swal.fire({
    icon:'success',
    text:'Pokemon added to trade list',
    toast:true,
    position:'top-left',
    timer: 3000,
    showConfirmButton:false
  })
}

//Add more content on scroll
$(window).scroll(function(){
  if(!isActive && $(window).scrollTop() + window.innerHeight == $(document).height()) {
     $('.loadingContent').show();
     isActive = true;
     AddMoreContent();
  }
});

//remove pokemon from trade list
function removePokeTrade(destiny,index){
  $(destiny+index+" .panel-body img").remove();
  $(destiny+index+" span").remove();
  if(destiny=='.ashPanel'){
    ashTradeList.splice(index,1);
  }else{
    teamRocketTradeList.splice(index,1);
  }
  buildTradeList(destiny);
  colorPokeballs(destiny);
  calculateTrade();
}



function calculateTrade(){
  ashListXP = 0;
  teamRocketListXP = 0;
  fair=0;
  if(ashTradeList.length>0 && teamRocketTradeList.length>0){
    $(ashTradeList).each(function(i){
      ashListXP += parseInt(ashTradeList[i].pokeXP);
    });
    $(teamRocketTradeList).each(function(i){
      teamRocketListXP += parseInt(teamRocketTradeList[i].pokeXP);
    });
    difference=Math.abs(ashListXP-teamRocketListXP);
    if(difference>50){
      $('#tradeResult').html('NOT FAIR');
      fair=0;
    }else{
      $('#tradeResult').html('FAIR');
      fair=1;
    }
    $('#ashXP').html('<i class="fa fa-fist-raised"></i> '+ashListXP+' - ');
    $('#teamRocketXP').html(' - '+teamRocketListXP+' <i class="fa fa-fist-raised"></i>');
    $('#tradeFooter').slideDown();
    $('#clearButton').css('visibility','visible');
  }else{
    $('#tradeFooter').slideUp();
    $('#clearButton').css('visibility','hidden');
    $('#tradeResult').html('?');
    $('#ashXP').html('');
    $('#teamRocketXP').html('');
    fair=0;
  }
}


function saveTrade(){
  if(ashTradeList.length>0 && teamRocketTradeList.length>0){
    $.ajax({
      url: '/saveTrade',
      type: 'POST',
      dataType: 'json',
      data: {ashList: ashTradeList, teamRocketList:teamRocketTradeList, fair:fair}
    })
    .done(function(data) {
      if(data=='success'){
        Swal.fire({
          icon:'success',
          title:'Success',
          text:'Trade saved !',
          timer: 8000,
        });
        clearTradeList();
      }
    });
  }else{
    Swal.fire({
      icon:'warning',
      text:'At least one Pokemon on each side required to save the trade',
      timer: 5000
    })
  }
}

//clear Trade list info
function clearTradeList(){
  ashTradeList=[];
  teamRocketTradeList=[];
  fair=0;
  for(let i=0;i<=5;i++){
    removePokeTrade('.ashPanel',i);
    removePokeTrade('.rocketTeamPanel',i);
  }
}

function formatDate(date) {
  // data = new Date(date+" GMT-0300");
  data = new Date(date);
  var year = data.getFullYear();

  var month = (1 + data.getMonth()).toString();
  month = month.length > 1 ? month : '0' + month;

  var day = data.getDate().toString();
  day = day.length > 1 ? day : '0' + day;

  var hour = data.getHours().toString();
  var minute = data.getMinutes().toString();
  minute = minute.length > 1 ? minute : '0' + minute;
  var second = data.getSeconds().toString();
  second = second.length > 1 ? second : '0' + second;

  return day + '/' + month + '/' + year + ' - ' + hour + ':' + minute + ':' + second;
}


function getTradeHistory(){
  $.ajax({
    url: '/tradeHistory',
    type: 'get',
    dataType: 'json'
  })
  .done(function(data) {
    $('#tradeHistoryBody').html('');
    $(data).each(function(i){
      if(data[i].fair==1){
        historyFair='Fair';
      }else{
        historyFair='Unfair';
      }
      ashPokemons = (data[i].ashPokemons).split(',');
      ashPokemonsHTML='';
      $(ashPokemons).each(function(j){
        ashPokemonsHTML+=`<img src='img/pokemons/`+ashPokemons[j]+`.png' style='width:40px' title='`+ashPokemons[j]+`' data-toggle="tooltip"/>`;
      });
      teamRocketPokemons = (data[i].teamRocketPokemons).split(',');
      teamRocketPokemonsHTML='';
      $(teamRocketPokemons).each(function(j){
        teamRocketPokemonsHTML+=`<img src='img/pokemons/`+teamRocketPokemons[j]+`.png' style='width:40px' title='`+teamRocketPokemons[j]+`' data-toggle="tooltip"/>`;
      });
      $('#tradeHistoryBody').append(`
        <tr>
          <td>#`+data[i].id+`</td>
          <td>`+ashPokemonsHTML+`</td>
          <td>`+teamRocketPokemonsHTML+`</td>
          <td>`+historyFair+`</td>
          <td>`+formatDate(data[i].created_at)+`</td>
        </tr>
        `)
    });
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('#tradeHistory').modal();
}



function updateDatabase(){

  Swal.fire({
    title: 'This action can take a long time to complete!',
    text:'Are you sure you want to proceed?',
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: `Run anyway`,
    denyButtonText: `Don't run`,
  }).then((result) => {
      if (result.isConfirmed) {
          Swal.showLoading();
          $.ajax({
            url: '/updatePokedex',
            type: 'GET',
            dataType: 'json',
            beforeSend:function(){
            Swal.fire({
              showConfirmButton: false,
              type: 'info',
              title: 'Proccessing... ',
              allowOutsideClick:false,
              allowEscapeKey: false,
            })
            Swal.showLoading();
          },success:function(data){
            Swal.fire({
              title:'Database updated!',
              icon:'success'
            }).then((result)=>{
              if(result.isConfirmed){
                location.reload();
              }
            });
          },error: function(xhr) { // if error occured
              Swal.fire('Database not updated!', 'Something went wrong...', 'error');
          }
        });
      }else if (result.isDenied) {
          Swal.fire('Action canceled', '', 'info')
      }
  });
}
