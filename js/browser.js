function init(path, base) {
    browser({
        contentsDisplay     :   document.getElementById("directoryContent"),
        openFolderOnSelect  :   true,
        currentPath         :   path,
        base                :   base,

        onSelect:function(item,params) {

            if(item.type != "folder") {
                var path = 'img/' + base + item.path;
                $('#imagePreview').attr('src',path);
                $('#imageName').html(item.title);
                $('#action').css('visibility' , 'visible').prop('value',path);
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