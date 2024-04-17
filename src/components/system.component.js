
//Includes
var V_Global = 'http://localhost/cisnaturatienda/';//Global server connection
var V_Domain = ''; //Global cookies domain

//System methods to excecute...
var system = {
	/*
	you will type your methods that you will need in your platform in same modules here 
		Example: 
			getTime()...
			getToken()...
			convertTime()...
	*/
    showLoader: function () {
        const loaderContainer = document.createElement("div");
        loaderContainer.classList.add("loader-container"); //loader-container
        const loader = document.createElement("div");
        loader.classList.add("loader"); //loader
        loaderContainer.appendChild(loader);
        $("#loader").append(loaderContainer);
        loaderContainer.style.display = "block";
        return loaderContainer;
    },

    hideLoader: function (loaderContainer) {
        loaderContainer.style.display = "none";
    },
    platform:{
        session: {
            force: function(){
                //redirige al usuario a login.php
                window.location.href = V_Global + "src/views/auth/login.php";
            }
        }
    },
	http: {
		send: {
			authorization: () => {
                try{
                    var SSID = $.cookie('SSID');
                    var SSK = $.cookie('SSK');
                    var APISS__NME = $.cookie('APISS__NME');
                    if(
                        (!SSID) || 
                        (!SSK) || 
                        (!APISS__NME)
                    ){
                        return system.platform.session.force();
                    } 
                    
                    //return the session authorization
                    return btoa(JSON.stringify({
                        SSID: SSID,
                        SSK: SSK,
                        APISS__NME: APISS__NME
                    }));
                }catch(error){
                    return system.platform.session.force();
                }
            }
		}
	},
    //system.platform.session.force()

    verMasBtn: function(buttonId, contentId) {
        const button = document.getElementById(buttonId);
        const content = document.getElementById(contentId);

        button.addEventListener("click", () => {
            content.classList.remove("hidden");
            button.style.display = "none";
        });
    },
}