$( document ).ready(function() {
$("#modalLost").modal('show');

$("#login :input").tooltipster({
    trigger: "custom",
    animation: 'grow',
    theme: 'tooltipster-xxxxxxx',
    onlyOne: false,
    position: 'bottom',
    multiple:true,
    autoClose:false
    });


$("#login").submit(function( e ){
	e.preventDefault();
	
	if($("#login").valid())
	{
		//alert($("#id").val().toUpperCase());

		var donnees = {
			"id" : $("#id").val().toUpperCase()
		};
        
		//alert(donnees);

        $.ajax({
			type : "POST",
			url : "ajax/lostpass.php",
			encode : true,
			data : donnees, // on envoie via post
			success: function(json) {
				console.log(json);
				$("#ModalRetour").find("p").html(json['message']);
				hd();
				$("#ModalRetour").modal('show');
				
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
	else
	{
		alert("ko");
	}

});

$("#login").validate({
	errorPlacement: function (error, element) {
        if (error[0].innerHTML != null && error[0].innerHTML !== "") {
            $(element).tooltipster('content', $(error).text());
            $(element).tooltipster('open'); //open only if the error message is not blank. By default jquery-validate will return a label with no actual text in it so we have to check the innerHTML.
        }
    },
    success: function (label, element) {
        var obj = $(element);
        if (obj.hasClass('tooltipstered') && obj.hasClass('error')) {
            $(element).tooltipster('close'); //hide no longer works in v4, must use close
        }   
    },

    rules: {
        id: {required: true, minlength: 2},
      },
      messages: {
        id: {
              required: "Vous devez saisir un identifiant valide !",
              minlength: "L'identifiant doit faire au minimum 2 caractères."
            },
        }
    });
});

            
function hdModalRetour(){
	$("#ModalRetour").modal("hide");
	document.location.href="Accueil";
}
function hd(){
	//document.location.href="Accueil";
	$("#modalLost").modal("hide");
	 var instances = $.tooltipster.instances();
	 $.each(instances, function(i, instance){
	     instance.close();
	 });
	 
}