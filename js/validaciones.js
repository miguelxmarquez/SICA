/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
//---------------------------------------------------------------------------------------------

function checkbox(esto){
    valido=0;
    for(a=0;a<esto.elements.length;a++){
        if(esto[a].type=="checkbox" && esto[a].checked==true){
            valido+=1;
        }

    }
    if(valido!=1){
        alert("Debe chequear una casilla!!");
        return false;
    }

} 


function permite(elEvento, permitidos) {
    // Variables que definen los caracteres permitidos
    var numeros = "0123456789";
    var letras = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ";
    var car = numeros+letras+"-/.(),";
    var numc = numeros+"-/.(),";
    var numeros_letras = numeros + letras;
    var numg= numeros+"-";
    var numd= numeros+".";
    var sangre= letras+"+";
    // Seleccionar los caracteres a partir del parámetro de la función
    switch(permitidos) {
        case 'n':
            permitidos = numeros;
            break;
        case 'l':
            permitidos = letras;
            break;
        case 'nl':
            permitidos = numeros_letras;
            break;
        case 'nlc':
            permitidos = car;
            break;
        case 'nc':
            permitidos = numc;
            break;
        case 'ng':
            permitidos = numg;
            break;
        case 'nd':
            permitidos = numd;
            break;
        case 'sangre':
            permitidos = sangre;
            break;
    }
    // Obtener la tecla pulsada
    var evento = elEvento || window.event;

    var codigoCaracter = evento.charCode || evento.keyCode;
    var caracter = String.fromCharCode(codigoCaracter);
    // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
    if(evento.keyCode==8 || evento.charCode==32 || evento.keyCode==9){	 
        return true;
    }
    return permitidos.indexOf(caracter) != -1;
}
//----------------------------------------------------
function espneg(elEvento){
    var evento = elEvento || window.event;

    var codigoCaracter = evento.charCode || evento.keyCode;
    var caracter = String.fromCharCode(codigoCaracter);
    // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
    if(evento.charCode==32 ){	 
        return false;
    }
    return true;	  
}
//--------------------------------------------------------
    

//    nota: ejemplo solo se llama en la etiqueta input asi: <input id="Busq" name="Busq" type="text" maxlength="20" onkeypress="return permite(event, 'nlc')" />
//
//    permite(event, 'nlc') -> nlc:numeros letras caracteres, n: numeros ,l letras
//
function show_clock(){
    if (!document.layers&&!document.all&&!document.getElementById)
        return
    var Digital=new Date()
    var hours=Digital.getHours()
    var minutes=Digital.getMinutes()
    var seconds=Digital.getSeconds()
    var dn="AM" 
    if (hours>12){
        dn="PM"
        hours=hours-12
    }
    if (hours==0)
        hours=12
    if (minutes<=9)
        minutes="0"+minutes
    if (seconds<=9)
        seconds="0"+seconds
    //change font size here to your desire
    myclock="<font size='5' face='Arial' ><b><font size='1'>Hora actual:</font></br>"+hours+":"+minutes+":"
    +seconds+" "+dn+"</b></font>"
    if (document.layers){
        document.layers.liveclock.document.write(myclock)
        document.layers.liveclock.document.close()
    }
    else if (document.all)
        liveclock.innerHTML=myclock
    else if (document.getElementById)
        document.getElementById("liveclock").innerHTML=myclock
    setTimeout("show5()",1000)
}
