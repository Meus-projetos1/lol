$("#button-addon2").click(function () {
  var data = new FormData();

  data.append("nome", $("#nome").val());
  $("#load").css("display", "");
  $(".sr-only").text("Buscando");

  $.ajax({
    url: "./routes/cadastroUsuario.php",
    type: "POST",
    data: data,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    success: function (data, textStatus, jqXHR) {
      maestria(data.maestria[0]);
      campeao(data.campeoes.data, data.maestria[0], data.invocador);
      elo(data.ranqueada);
      $("#main").css("display", "");
      removeload();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(errorThrown);
      removeload();
    },
  }).done(function (data) {
    removeload();
  });
});

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

  debugger
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
}

function campeao(campeao, maestria, invocador) {
  $("#icone").attr("src", `assets/profileicon/${invocador.profileIconId}.png`);

  for (var propriedade in campeao) {
    if (campeao[propriedade].key == maestria.championId) {
      $("#imgCampeao").attr(
        "src",
        `assets/campeao/${campeao[propriedade].name}_0.jpg`
      );
      $(".card-title").text(campeao[propriedade].name);
      $(".card-text").text(campeao[propriedade].title);
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
