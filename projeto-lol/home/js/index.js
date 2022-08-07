$(document).ready(function () {
  validaInput();
});
var valid = false;
var invocador = [];


function validaInput() {
  $("#nome").keyup(function () {
    let nome = $("#nome").val();
    let espacoFim = nome.substring(-1, 1).indexOf(" ") >= 0
    let espacoComeco = nome.substring(nome.length - 1).indexOf(" ") >= 0
  
    if (espacoComeco || espacoFim ) {
      $("#feedback").text("Tem espaços no começo ou no fim do nome");
      $("#nome").addClass("is-invalid");
      $("#button-addon2").attr("disabled","");
      $("#nome").removeClass("is-valid");
      valid = false;
    } else {
      $("#feedback").text("");
      $("#nome").addClass("is-valid");
      $("#button-addon2").removeAttr("disabled");
      $("#nome").removeClass("is-invalid");
      valid = true;
    }
    nome == '' ?  $("#button-addon2").attr("disabled", '') : ''
              
  });
}

$("#button-addon2").click(function () {

  invocador = [];
  if($("#nome").val() == "" || !valid ) return false;

  var data = new FormData();
   
  data.append("nome", $("#nome").val());
  $("#load").css("display", "");
  $('.sr-only').text('Buscando')
 
  $.ajax({
    url: "./routes/cadastroUsuario.php",
    type: "POST",
    data: data,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    success: function (data, textStatus, jqXHR) {

      invocador.push(data.invocador.puuid);
      invocador.push(data.invocador.name);
     
      if(data.statusMsg != null){
        $("#feedback").text(data.statusMsg );
        $("#nome").addClass("is-invalid");
        return false;
      }
      maestria(data.maestria[0]);
      campeao(data.campeoes.data, data.maestria[0], data.invocador);
      elo(data.ranqueada);
      $("#main").css("display", "");
      removeload();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#load").css("display", "");
      console.error(errorThrown);
      removeload();
    },
  }).done(function (data) {
    $("#load").css("display", "");
    removeload();
  });
});

$("#salvar").click(function(){

  $('#buttons').css('display', 'none');
  $('#loading').css('display', '');
  $('.carregando').css('display', '');
  $('#loading').find('h5').text('Cadastrando...');
  
  var data = new FormData();

  data.append('puuid', invocador[0])
  data.append('nome', invocador[1])

  $.ajax({
    url: "./routes/salvaInvocador.php",
    type: "POST",
    data: data,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    success: function (data, textStatus, jqXHR) {
         
        if (data.result == 0) {
          $('#loading').find('h5').text('Cadastrado com sucesso!');
          $('.carregando').css('display', 'none');
          $('#check').css('display', '');
        }else {
          $('#loading').find('h5').text(`O Invocador "${data.result[0].nome}" já está cadastrado`)
          $('.carregando').css('display', 'none');
        }

     

      
    },
    error: function (jqXHR, textStatus, errorThrown) {
     
      console.error(errorThrown);
      
    },
  }).done(function (data) {
    
    
  });
});




$("#naoModal").click(function () {
  $('.modal').removeClass('show');
  $('.modal-backdrop').removeClass('show');
})
$("#Cadastrar").click(function () {
  $('#buttons').css('display', '');
  $('#loading').css('display', 'none');
  $('#check').css('display', 'none');
  
})

function removeload() {
  $("#load").css("display", "none");
  $(".sr-only").text("Buscar");
}



function elo(ranqueada) {
  if (ranqueada.length > 0) {
    $(ranqueada).each(function (index, elo) {
      let eloAtual = caseElo(elo.tier);

      if (elo.queueType == "RANKED_SOLO_5x5") {
        $("#elo-solo").text(eloAtual + " " + elo.rank);
        $("#vitorias-solo").html(
          'Vitorias : <span style="color: green;"> ' + elo.wins + "</span>"
        );
        $("#derrotas-solo").html(
          'Derrotas : <span style="color: red;"> ' + elo.losses + "</span>"
        );
        $("#elo-icone-solo").attr(
          "src",
          `assets/ranked-emblems/${elo.tier}.png`
        );
      }
      if (elo.queueType == "RANKED_FLEX_SR") {
        $("#elo-flex").text(eloAtual + " " + elo.rank);
        $("#vitorias-flex").html(
          'Vitorias : <span style="color: green;"> ' + elo.wins + "</span>"
        );
        $("#derrotas-flex").html(
          'Derrotas : <span style="color: red;"> ' + elo.losses + "</span>"
        );
        $("#elo-icone-flex").attr(
          "src",
          `assets/ranked-emblems/${elo.tier}.png`
        );
      }
    });
  }

  if ($("#elo-icone-flex").attr("src") == "") {
    semElo("flex");
  }
  if ($("#elo-icone-solo").attr("src") == "") {
    semElo("solo");
  }
}
function semElo(fila) {
  $("#elo-" + fila).text("SEM RANKING");
  $("#vitorias-" + fila).html(
    'Vitorias : <span style="color: green;">0</span>'
  );
  $("#derrotas-" + fila).html('Derrotas : <span style="color: red;">0</span>');
  $("#elo-icone-" + fila).attr("src", `assets/ranked-emblems/UNRANKED.png`);
}

function maestria(maestria) {
  if (maestria.championLevel >= 4) {
    $("#maestria").attr(
      "src",
      `assets/maestria/lvl${maestria.championLevel}.png`
    );
  }
  $("#maestriaPontos").text(`}`);
}

function campeao(campeao, maestria, invocador) {
  $("#icone").attr("src", `assets/profileicon/${invocador.profileIconId}.png`);
  $("#nomeInvocador").text(invocador.name);

  for (var propriedade in campeao) {
    if (campeao[propriedade].key == maestria.championId) {
      $("#imgCampeao").attr(
        "src",
        `assets/campeao/${campeao[propriedade].name}_0.jpg`
      );
      $(".card-title").html(
        campeao[propriedade].name +
          " " +
          campeao[propriedade].title +
          "</br>" +
          `<p style="color:#9ca2aa";>— Pontos de Maestria #<span style="color: white"> ${maestria.championPoints.toLocaleString(
            "pt-BR"
          )}</span></p>`
      );
    }
  }
}

function caseElo(elo) {
  let eloTier = "";
  switch (elo) {
    case "IRON":
      eloTier = "FERRO";
      break;
    case "BRONZE":
      eloTier = "BRONZE";
      break;
    case "SILVER":
      eloTier = "PRATA";
      break;
    case "GOLD":
      eloTier = "OURO";
      break;
    case "PLATINUM":
      eloTier = "PLATINA";
      break;
    case "DIAMOND":
      eloTier = "DIAMANTE";
      break;
    case "GRANDMASTER":
      eloTier = "GRÃO MESTRE";
      break;
    case "CHALLENGER":
      eloTier = "DESAFIANTE";
      break;
    default:
      eloTier = "SEM RANKING";
  }

  return eloTier;
}
