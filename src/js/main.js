$(document).ready(() => {
var url = V_Global + "app/services/routes/main.route.php";
const main = {
  routes: {
    //rutas del navbar
    home: V_Global + "src/views/home.php",
    inisession: V_Global + "src/views/auth/login.php",
    register: V_Global + "src/views/auth/register.php",
    profile: V_Global + "src/views/auth/profile.php",
    app: V_Global + "app/services/routes/main.route.php",
  },
  view: function (route) {
    location.replace(this.routes[route]);
  },

  closeSession : function(){
    try {
      const res = fetch(url + '?_joder')
      const resJson = res.json();
      console.log(resJson);
    } catch (error) {
        console.error(error);
    }
  },
}  

});