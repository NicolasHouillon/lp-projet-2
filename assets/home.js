import $ from 'jquery';

const routes = require('../public/assets/js/fos_js_routes.json');

import Routing from 'fos-routing';

Routing.setData(routes);


let database = document.getElementById('database')
let db = database.value

$.ajax({
        url : Routing.generate('sujets'),
        type : 'GET',
        data : 'database=' + db,
        datatype : 'json',
        success : function(data){
            changeSujet(data)
        }
    }
)

$("#database").change(function(e){
    e.preventDefault();
    db = database.value
    $.ajax({
        url : Routing.generate('sujets'),
        type : 'GET',
        data : 'database=' + db,
        datatype : 'json',
        success : function(data){
            changeSujet(data)
            }
        }
    )
})


function changeSujet(data){
    $('#sujet option').remove();
    let sujets = document.getElementById('sujet')
    data.map(function(num){
            let option = document.createElement('option')
            option.setAttribute('value',num)
            option.innerText = num
            sujets.appendChild(option)
        }
    )
}