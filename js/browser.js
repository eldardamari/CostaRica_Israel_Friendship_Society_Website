function init(type, base) {
    browser({
        contentsDisplay     :   document.getElementById("directoryContent"),
        openFolderOnSelect  :   true,
        currentPath         :   '',
        base                :   base,
        onSelect            :   function(item,params) {

            if(item.type != "folder") {

                var path = 'img/' + base + item.path;
                $('#imagePreview').attr('src',path).css('display', 'inline-block');
                $('#previewName').html("<p>" + item.title + "</p>");

                $('#action').prop('value',path).prop('name','deletePhoto').css('visibility' , 'visible');
                $('#action').html('<span class="btn_icon icon_delete"></span> Remove Photo');

            } else {
                $('#imagePreview').css('display', 'none');

                if(item.title == "..") {
                    $('#previewName').html("");
                    $('#action').prop('name','').css('visibility' , 'hidden');

                } else {
                    var events = type.toLowerCase() + "s";

                    $.ajax({
                        url : "utils/get_event.php?id="+item.title+"&eventType="+events,
                        type: "GET",
//                        data: "" +  + "" + events,
                        dataType: "json",
                        success : function(result) {
                            var resultToString =    "<h2>" + type + " Details:</h2>" +
                                "<p>Name: " + result.name + "</p>" +
                                "<p>Date: " + result.date + "</p>" +
                                "<p>Description: " + result.description + "</p>";

                            $('#previewName').html(resultToString);
                        }
                    });

                    $('#action').prop('value',item.title).prop('name','deleteEvent').css('visibility' , 'visible');
                    $('#action').html('<span class="btn_icon icon_delete"></span> Remove ' + type);
                }
            }
        }
    });
}

function browser(params) {
	if(params == null)
        params={};

	if(params.contentsDisplay == null)
        params.contentsDisplay = document.body;

	if(params.currentPath == null)
        params.currentPath = "";

	if(params.data == null)
        params.data = "";

    if(params.base == null)
        params.base = "";

	var search = function() {

        $.ajax({
            url : "utils/search_dir.php",
            type: "POST",
            data: "path=" + params.currentPath + "&base=" + params.base + "&data="+params.data,
            dataType: "json",
            success : function(result) {
                showFiles(result);
            },
            error : function() {
                alert("failure");
            }
        });

	}
	
	var showFiles = function(res) {

		params.contentsDisplay.innerHTML="";
		var oddeven = "odd";
		
		for (var i=0 ; i < res.contents.length ; i++) {
			var f = res.contents[i];
			var element = document.createElement("p");
			with(element) {
				setAttribute("title", f.fName);
				setAttribute("fPath", f.fPath);
				setAttribute("fType", f.fType);
				className = oddeven + " item ft_" + f.fType;
				innerHTML = f.fName;
			}
			params.contentsDisplay.appendChild(element);

			oddeven = (oddeven == "odd")? "even" : "odd";
			element.onclick = selectItem;
		}
	}

	var selectItem = function() {
		var ftype = this.getAttribute("fType");
		var fpath = this.getAttribute("fPath");
		var ftitle = this.getAttribute("title");

		if(params.onSelect != null)
            params.openFolderOnSelect = params.onSelect({"type":ftype,"path":fpath,"title":ftitle,"item":this},params);

		if(params.openFolderOnSelect == null)
            params.openFolderOnSelect = true;

		if(ftype=="folder" && params.openFolderOnSelect) {
			params.currentPath = fpath;
			search();
		}
	}

	search();
}