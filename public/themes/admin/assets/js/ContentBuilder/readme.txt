*** InnovaStudio Content Builder 1.7.3 ***


Usage:

1. Includes:

	<link href="scripts/contentbuilder.css" rel="stylesheet" type="text/css" />

	<script src="scripts/contentbuilder.js" type="text/javascript"></script>

2. Run:

	$("#contentarea").contentbuilder({
		  zoom: 0.85,
		  snippetFile: 'snippets.html'
		  });

	The zoom parameter allows you to make the editing area smaller, to give you overall look of the content. Values can be 0.8 to 1.
	Content zoom can also be set from the slider under the content blocks.
	Note: zoom feature is not provided in Firefox browser.

	The snippetFile parameter refers to a html file containing snippets collection. You can add your own snippets in this file.

3. To get HTML:

    var sHTML = $('#contentarea').data('contentbuilder').html();
    alert(sHTML);

Others:

To load HTML at runtime:

	$("#contentarea").data('contentbuilder').loadHTML('<h1>Heading text</h1>');

To view HTML:

	$('#contentarea').data('contentbuilder').viewHtml();

To set the editing mode to "SAFE MODE":

	$("#contentarea").contentbuilder({
            editMode: 'safe',
            .....
            });

	Safe mode will make each text element fixed.
	In Safe mode, you can specify text elements that can be edited using "selectable" parameter: (this is optional)

	$("#contentarea").contentbuilder({
			editMode: 'safe',
            selectable: 'h1,h2,h3,h4,h5,h6,p,ul,ol,small,.edit',
            .....
            });

To make the snippet tool slide from left, use 'snippetTool' property, for example:

	$("#contentarea").contentbuilder({
            snippetTool: 'left',
            .....
            });

To enable custom image or file select dialog:

	$("#contentarea").contentbuilder({
            imageselect: 'images.html',
            fileselect: 'images.html',
            .....
            });


	- imageselect specifies custom page to open from the image dialog.
	- fileselect specifies custom page to open from the link dialog.
	
	Please see images.html (included in this package) as a simple example. 
	Use selectAsset() function as shown in the images.html to return a value to the dialog.

To disable zoom feature:

	$("#contentarea").contentbuilder({
            enableZoom: false,
            .....
            });

To disable/destroy the plugin at runtime:

        if ($('#contentarea').data('contentbuilder')) $('#contentarea').data('contentbuilder').destroy();

To specify custom colors:

	$("#contentarea").contentbuilder({
            colors: ["#ffffc5","#e9d4a7","#ffd5d5","#ffd4df","#c5efff","#b4fdff","#c6f5c6","#fcd1fe","#ececec",                            
                "#f7e97a","#d09f5e","#ff8d8d","#ff80aa","#63d3ff","#7eeaed","#94dd95","#ef97f3","#d4d4d4",                         
                "#fed229","#cc7f18","#ff0e0e","#fa4273","#00b8ff","#0edce2","#35d037","#d24fd7","#888888",                         
                "#ff9c26","#955705","#c31313","#f51f58","#1b83df","#0bbfc5","#1aa71b","#ae19b4","#333333"],
            .....
            });

To open snippet panel on first load:

	$("#contentarea").contentbuilder({
            snippetOpen: true,
            .....
            });

To run custom script when a block is dropped (added) to the content:

        $("#contentarea").contentbuilder({
            onDrop: function (event, ui) {
                alert(ui.item.html());  //custom script here
            },
            .....
        });

To run custom script when content renders/updated:

        $("#contentarea").contentbuilder({
            onRender: function () {
                //custom script here
            },
            .....
        });

To disable Direct Image Embed:

        $("#contentarea").contentbuilder({
            imageEmbed: false,
            .....
        });

To disable HTML source editing:

        $("#contentarea").contentbuilder({
            sourceEditor: false,
            .....
        });

If you want to develop your own panel, and don't want to use the sliding side panel for the snippets, 
you can use "snippetList" parameter. Please set this parameter with the ID of your custom DIV where you want to place all the snippets.
Important Note: 
Your must have your custom panel or DIV ready before using this feature. 
Developing custom panel is beyond of our support scope. 

        $("#contentarea").contentbuilder({
            snippetList: '#MyDivId',
            snippetFile: 'assets/default/snippets.html'
        });



*** EXAMPLES ***


Content Builder provides you with collection of snippets to drag & drop. 
You can customize the snippets (adding more, etc) by modifying the snippets file and its css.
The package contains 3 example of snippets that you can use:

- assets/default/snippets.html
  See example1.html

- assets/simple/snippets.html
  See example2.html

- assets/classic/snippets.html
  See example3.html



*** ADDITIONAL EXAMPLES ***


- example4.html (with Save button for saving into browser's localStorage)

	Step 1: Here is how to save into browser's localStorage:

		var sHTML = $('#contentarea').data('contentbuilder').html();
        localStorage.setItem('mycontent', sHTML);

	Step 2: Here is hpw to read content from browser's localStorage:

		$("#contentarea").html(localStorage.getItem('mycontent'));


- example5.php and example5.aspx (shows how to save embedded images into files and then save content to the server)

	Step 1: Include SaveImages.js plugin:

		<script src="scripts/saveimages.js" type="text/javascript"></script>

	Step 2: Implement Saving as follows:

		function save() {
        
			//Save Images
			$("#contentarea").saveimages({
				handler: 'saveimage.php',
				onComplete: function () {

					//Get Content
					var sHTML = $('#contentarea').data('contentbuilder').html();

					//Save Content
					.....

				}
			});
			$("#contentarea").data('saveimages').save();

		}

	Step 3: Specify folder on the server for storing images on saveimage.php (or saveimage.ashx if you're using .NET).

	Step 4: In this example, we use AJAX to post content to the server.
		
		In this example, we post content to savecontent.php (or savecontent.ashx) which save the content to content.html file

		var sHTML = $('#contentarea').data('contentbuilder').html();
		$.ajax({
            url: "savecontent.php",
            type: "post",
            data: {
                content: sHTML
            }
        }); 

- example6.html (multiple instance example)

- example7.html (flexible editing example)

	In this example, we introduce a "selectable" property which you can use to specify the cell/column class name.
	This will make the entire cell/column editable.

        $("#contentarea").contentbuilder({
            ...
            selectable: '.column',
            ...
        });


*** SUPPORT ***

Note: 
Once content is submitted to the server, it is more of to user's custom applications (eg. saving into a file, database, etc).
PHP programming or ASP.NET programming on the server is beyond of our support scope.

Email us at: builder@innovastudio.com

_____________
Please enjoy!
