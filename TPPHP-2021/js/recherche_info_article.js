$("#modifarticle").show();
	$.ajax({
   					type: "POST",
        			url: "ajax/recherche_info_article.php",
        			dataType: "json",
					encode          : true,
        			data: "id_article="+id, // on envoie via post
        			success: function(retour) {
						$("#h3").val(retour["h3"]);
						$("#date_deb").val(retour["date_deb"]);
						$("#date_fin").val(retour["date_fin"]);
						$("#corps").val(retour["corps"]);
				
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
	
