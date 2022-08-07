// $(document).ready(function() {

   $('#indexPage').load('./home/index.html', (responseTxt, statusTxt,
      xhr) => {
      if (statusTxt == "success") {
    
      } else if (statusTxt == "error") {
          console.log("Error: " + xhr.status + " : " + xhr.statusText);
      }
  })

  
//   })