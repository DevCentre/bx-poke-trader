$(document).ready(function() {
    pageOffset = 12;
});

function AddMoreContent() {
    $.get('/getDataPokedex/'+pageOffset, function(data) {

      console.log(data);
      $(data).each(function(i){
        pokeName = data[i].poke_name;
        pokeNumber = (data[i].pokeURL).split('/')[6];
        content =
        `<div class="col-lg-3">
              <div class="pokemon panel panel-primary">
                  <div class="panel-heading">
                      <h1>
                          ` + pokeName + `
                          <span class="label label-primary pull-right"># ` + pokeNumber + ` </span>
                      </h1>
                  </div>
                  <div class="panel-body">
                      <a >
                          <img class="avatar center-block" src="img/pokemons/`+pokeName+`.png">
                      </a>
                  </div>
                  <div class="panel-footer">
                      <div class="text-center">`;
                        $(data[i].types).each(function(j){
                          content += `<a>
                                        <span class="label type type-`+data[i][j]+`">
                                            `+data[i][j]+`
                                        </span>
                                      </a>`;
                        });

        content += `</div>
                  </div>
              </div>
          </div>`;

          $(content).insertBefore($('#moreContent'));
      });
      $('.loadingContent').hide();
    });
    pageOffset=pageOffset+12;

}



$(window).scroll(function(){
   if($(window).scrollTop() == $(document).height() - $(window).height()){
      $('.loadingContent').show();
      setTimeout(function(){
        AddMoreContent();
      },2000);
   }
});
