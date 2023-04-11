/* 
min 56:01
creamos ua variable llamada dropdowns(lsitas deplegables)
-> tomamos el documento y le decimos que vamos a seleccionar todos los selectores con la clase .dropdown
-> luego haremos un bucle para recorrer las listas
*/

var dropdowns = document.querySelectorAll(".dropdown-list");
for (var i = 0; i < dropdowns.length; i++) {
	dropdowns[i].classList.add("hide");
}
/*Este ciclo for recorre todos los elementos de la clase "dropdown" en el sitio web y agrega la clase "hide" a cada uno de ellos, lo que oculta los menús desplegables.*/

var dropdowns = document.querySelector("header").querySelectorAll(".dropdown");

/*Esta línea de código busca todos los elementos con la clase "dropdown" dentro del elemento "header" del sitio web y los guarda en la variable "dropdowns".*/

for (var i = 0; i < dropdowns.length; i++) {

	dropdowns[i].addEventListener("click", function(e){

		var links = e.currentTarget.parentNode.querySelectorAll(".dropdown-list");
		for (var i = 0; i < links.length; i++) {
			if (e.currentTarget.querySelector(".dropdown-list") != links[i])
				links[i].classList.add("hide");
			
		}
		e.currentTarget.querySelector(".dropdown-list").classList.toggle("hide");
	});
}

/* Este código establece un evento "click" para cada elemento de la clase "dropdown" en el sitio web. Cuando el usuario hace clic en uno de ellos, se ejecuta esta función.

Dentro de la función, se establece la variable "links" como todos los elementos con la clase "dropdown-list" dentro del elemento padre del elemento que se hizo clic.

Luego, se recorre cada elemento de "links" y se agrega la clase "hide" a los elementos que no corresponden al menú desplegable actualmente seleccionado, ocultando así todos los demás menús desplegables.

Por último, se agrega o quita la clase "hide" del menú desplegable actualmente seleccionado, mostrando u ocultando así su contenido. */

//-------------------------------------------

var links = document().querySelector("header").querySelectorAll(".nav-item");
for (var i = 0; i < links.length; i++){

	if (links[i].children[0].href == window.location.href || links[i].children[0].href+"/" == window.location.href) {
		links[i].classList.add("active")
	}
} 

/*
En primer lugar, la línea "var links = document().querySelector("header").querySelectorAll(".nav-item");" define una variable "links" y utiliza la función "querySelectorAll()" para buscar todos los elementos del DOM que tienen la clase "nav-item" dentro del elemento "header".

A continuación, el código inicia un bucle "for" que recorre cada uno de los elementos encontrados en la variable "links". En cada iteración del bucle, se comprueba si el valor de "href" del primer hijo del elemento actual es igual a la URL actual de la página web ("window.location.href"). Si es así, el código agrega la clase "active" al elemento actual con la línea "links[i].classList.add("active")".

En resumen, este código busca los elementos del menú de navegación de una página web y agrega la clase "active" al elemento correspondiente si su enlace es igual a la URL actual de la página. Esto se utiliza comúnmente para resaltar el elemento de navegación activo en una barra de navegación o menú en una página web.
*/ 
