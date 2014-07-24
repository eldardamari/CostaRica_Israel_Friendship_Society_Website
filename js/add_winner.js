$(document).ready(function() {
    $(".general_form").submit(function(e) {
      var statusi = $('.status');
      var percent = $('.percent');
      var bar = $('.bar');
        //grab all form data  
        var data = new FormData($('#winner_form')[0]);
        e.preventDefault();

            $.ajax({
                url: '/costaRicaIsrael/add_winner.php',
                type: 'POST',
                datatype : "json",
                data: data,
                cache: false,
                contentType: false,
                processData: false,

                /* reset before submitting */
                beforeSend: function() {
                    statusi.fadeOut();
                    bar.width('0%');
                    percent.html('0%');
                    alert("beforeSed");
                },

                /* progress bar call back*/
                uploadProgress: function(event, position, total, percentComplete) {
                    var pVel = percentComplete + '%';
                    alert(pVel);
                    bar.width(pVel);
                    percent.innerHTML += "baaaaaa";
                },
                /*xhr: function()
            {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        
                        //Do something with upload progress
                        console.log(percentComplete);
                    }
                }, false);
                return xhr;
            },*/
                complete: function(data){
                    if(data.error) {
                        alert("ERROR");
                    } else {
                        document.write(data);
                    }
                },
                success: function(data){
                    alert("SUCCESSS");
                    if(data.error) {
                        alert("ERROR");
                    } else {
                        document.write(data);
                    }
                },
                error: function(data) {
                    document.write(data);
                }
            });

            e.preventDefault();
            alert("ajax out");
        /*$.ajax({
          type: 'POST',
          url: "../add_winner.php",
          data: fd,
          xhr: function()
          {
          var xhr = new window.XMLHttpRequest();
        //Upload progress
        xhr.upload.addEventListener("progress", function(evt){
        if (evt.lengthComputable) {
        var percentComplete = evt.loaded / evt.total;
        alert(percentComplete);
        //Do something with upload progress
        console.log(percentComplete);
        }
        }, false);
        //Download progress
        xhr.addEventListener("progress", function(evt){
        if (evt.lengthComputable) {
        var percentComplete = evt.loaded / evt.total;
        //Do something with download progress
        console.log(percentComplete);
        }
        }, false);
        return xhr;
        },
        success: function (data) {
        alert("Data Uploaded: "+data);
        }
        });*/


    });

});

