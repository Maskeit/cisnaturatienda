  //Validate Name Method
  export const validateName = (nombre) => {
    if (nombre != "") {
      // Verificar si el nombre contiene caracteres no válidos
      if (/[^a-zA-Z\s]/.test(nombre)) {
        $("#name-invalid").removeClass("d-none").addClass("d-block");    
        $("#name").removeClass("is-valid").addClass("is-invalid");
        
        return "error";
      }
      const fname = nombre.toLowerCase().trim();
      const validName = fname.replace(/(^\w{1})|(\s+\w{1})/g, (letra) =>
        letra.toUpperCase()
      );
        $("#name-invalid").removeClass("d-block").addClass("d-none");
        $("#name").removeClass("is-invalid").addClass("is-valid");
        
      return validName;
    }else if(nombre == ""){
      $("#name").removeClass("is-valid").addClass("is-invalid");
    }
    
    return "error";
  }
  
  //Validate Email Method
  export const validateEmail = (correo) => {
    const email = correo.trim();
    const req = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/; // Expresión regular para validar el correo electrónico
    if (!req.test(email) || email == "") {
      $("#email-invalid").removeClass("d-none");
      $("#email-invalid").addClass("d-block");
      $("#email").removeClass("is-valid").addClass("is-invalid");
      
      return false;
    } else if (req.test(email)) {
      $("#email-invalid").removeClass("d-block");
      $("#email-invalid").addClass("d-none");
      $("#email").removeClass("is-invalid").addClass("is-valid");
      
      return true;
    }
    
    return false;
  };
  //Validate Pass Method
  export const validatePass = (pwd, pwd2) => {
    const password = pwd.trim();
    const password2 = pwd2.trim();

    if ((password == "" || password2 == "") || (password !== password2)) {
      $("#pwd-invalid").removeClass("d-none").addClass("d-block");
      $("#pwd-invalid2").removeClass("d-none").addClass("d-block"); 
      $("#passwd").removeClass("is-valid").addClass("is-invalid");
      $("#passwd2").removeClass("is-valid").addClass("is-invalid");
      
      return false;
    } else if ((password != "" && password2 != "") && (password === password2)) {
      const req = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[?$@!%*?&.()\-+=~/])([A-Za-z\d$@$!%*?&.()\-+=~/]|[^ ]){8,}$/;
      const result = req.test(password);
      if (result) {
        $("#pwd-invalid").removeClass("d-block").addClass("d-none");
        $("#pwd-invalid2").removeClass("d-block").addClass("d-none");
        $("#pwd-invalid3").removeClass("d-block").addClass("d-none");        
        $("#passwd").removeClass("is-invalid").addClass("is-valid");
        $("#passwd2").removeClass("is-invalid").addClass("is-valid");
        
        return true;
      }else{ //si fueron iguales pero no validas
      $("#pwd-invalid3").removeClass("d-none").addClass("d-block");
      $("#pwd-invalid").removeClass("d-block").addClass("d-none");
      $("#pwd-invalid2").removeClass("d-block").addClass("d-none");
      
        return false
      }
    }
    
    return false;
  }
  /********** */
  export const typeEmailLog = (correo) => {
    const email = correo.trim();
    const req = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    if (!req.test(email) || email == "") {
      $("#email").removeClass("is-valid").addClass("is-invalid");
      return false;
    }else if(req.test(email)){
      $("#email").removeClass("is-invalid").addClass("is-valid");
      return true;
    }
  }
  export const typePassLog = (pwd) => {
    const password = pwd.trim();
    if (password == "") {
      $("#passwd").removeClass("is-valid").addClass("is-invalid");
      return false;
    }
    $("#passwd").removeClass("is-invalid").addClass("is-valid");
    return true;
  }