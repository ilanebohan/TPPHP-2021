$( document ).ready(function() {
	$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
    $( "#date_deb" ).datepicker({changeYear: true,dateFormat: "yy-mm-dd"},"setDate", $("#date_deb").val());
    $( "#date_fin" ).datepicker({changeYear: true,dateFormat: "yy-mm-dd"},"setDate", $("#date_fin").val());
	CKEDITOR.replace( "corps" );
	$("#modifarticle").submit(function( e ){
		//alert("submit");
		e.preventDefault();
		var $url="http://localhost/TPPHP-2021/ajax/valide_article.php";
			
			var formData = {
				"titre" 					: $("#h3").val(),
				"date_deb"					: $("#date_deb").val(),
				"date_fin"					: $("#date_fin").val(),
				"corps"						: CKEDITOR.instances.corps.getData()
			};
	
			var filterDataRequest = $.ajax(
			{
	
				type: "POST",
				url: $url,
				dataType: "json",
				encode          : true,
				data: formData,
	
			});
			filterDataRequest.done(function(data)
			{
				if ( ! data.success)
				{
					var $msg="erreur-></br><ul style=\"list-style-type :decimal;padding:0 5%;\">";
					if (data.errors.message) {
						$x=data.errors.message;
						$msg+="<li>";
						$msg+=$x;
						$msg+="</li>";
					}
					if (data.errors.requete) {
						$x=data.errors.requete;
						$msg+="<li>";
						$msg+=$x;
						$msg+="</li>";
					}
	
					$msg+="</ul>";
				}
				else
				{
					$msg="";
					if(data.message){$msg+="</br>";$x=data.message;$msg+=$x;}
				}
	
	
			$("#ModalRetour").find("p").html($msg); $("#ModalRetour").modal('show');
	
			});
			filterDataRequest.fail(function(jqXHR, textStatus)
			{
	
				if (jqXHR.status === 0){alert("Not connect.n Verify Network.");}
				else if (jqXHR.status == 404){alert("Requested page not found. [404]");}
				else if (jqXHR.status == 500){alert("Internal Server Error [500].");}
				else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");}
				else if (textStatus === "timeout"){alert("Time out error.");}
				else if (textStatus === "abort"){alert("Ajax request aborted.");}
				else{alert("Uncaught Error.n" + jqXHR.responseText);}
			});
	});
});
function modif_article(id){
		//alert(id);
        var url = 'http://localhost/TPPHP-2021/ajax/recherche_info_article.php';
        var donnees = {"id_article":id};
        
        $.ajax({
			type : "POST",
			url : url,
			dataType : "json",
			encode : true,
			data : donnees, // on envoie via post
			success: function(json) {
                console.log(donnees);
				console.log(json);
				//$("#modifarticle").modal('show');
				document.getElementById("h3").value = json['h3'];
				document.getElementById("corps").value = json['corps'];
				document.getElementById("date_deb").value = json['date_deb'];
				document.getElementById("date_fin").value = json['date_fin'];
				$("#modifarticle").css("display","block");
				CKEDITOR.instances['corps'].setData(json["corps"]);
				
			},
			error: function(jqXHR, textStatus)
				{
					if (jqXHR.status === 0){alert("Not connect.n Verify Network.");}
					else if (jqXHR.status == 404){alert("Requested page not found. [404]");}
					else if (jqXHR.status == 500){alert("Internal Server Error [500].");}
					else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");}
					else if (textStatus === "timeout"){alert("Time out error.");}
					else if (textStatus === "abort"){alert("Ajax request aborted.");}
					else{alert("Uncaught Error.n" + jqXHR.responseText);}
				}
		});
}

function hdModalRetour(){
	$("#modifarticle").modal("hide");
	document.location.href="Accueil";
}

