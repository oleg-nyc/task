$(function() {
var taskTable = $("#tasks-table");
    taskTable.jsGrid({
            height: "auto",
            width: "100%",
            filtering: false,
            inserting: true,
            editing: true,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 5,
			noDataContent: "Empty",
            pageButtonCount: 5,
            confirmDeleting: false,
			invalidNotify: function(args) {
				var messages = $.map(args.errors, function(error) {
					return error.field + ": " + error.message;
					//console.log(error);
				});
			},
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "/api/",
                        data: filter
                    });
                },
                insertItem: function(item) {
                    return $.ajax({
                        type: "POST",
                        url: "/api/",
                        data: item
                    });
                },
                updateItem: function(item) {
					item.sid = sid;
                    $.ajax({
                        type: "PUT",
                        url: "/api/",
                        data: item
                    }).done(function(data){
						if( data == false ){
							if( confirm("Permission Denied, would you like to login?") == true ) window.location="/admin";
								else window.location="/";
						}
				});
                },
                // deleteItem: function(item) { }
            },
            fields: [
                { name: "name", title: "Name", type: "text", validate: "required" },
                { name: "email", title: "E-mail", type: "text", validate: {
						validator: function(value, item) {
							return /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(value);
						},
						massage: "Please type valid e-mail",						
						parm: []
					}
				},                
				{ name: "task", title: "Task", type: "text", validate: "required", 
					itemTemplate: function(value, item) {
					  return $("<input>")
						.addClass("code-protected")
						.attr("type","text")
						.attr("readonly","readonly")
						.val(value);
					} 
				},
                { name: "done", type: "checkbox", title: "Is Done", filtering: false },
                { type: "control", sorting: false, filtering: false },

            ],

			onItemDeleting: function(args) {
					args.item.sid = sid;
				 $.ajax({
					 type: "DELETE",
					 url: "/api/",
					 data: args.item,
					 async: false,
				 }).done(function(data){
					if(data==false){
						args.cancel = true;
						if (confirm("Permission Denied, would you like to login?") == true) window.location="/admin";
					}
				});
			},

			onItemEditing: function(args) {		
				 $.ajax({
					 type: "PUT",
					 url: "/api/",
					 data: {"sid" : sid},
					 async: false,
				 }).done(function(data){
					if(data==false){
						args.cancel = true;
						if (confirm("Permission Denied, would you like to login?") == true) window.location="/admin";
					}
				});
			}
	});

});
