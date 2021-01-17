import {elt} from "codemirror/src/util/dom";

require('../assets/app')

import $ from 'jquery';

const routes = require('../public/js/fos_js_routes.json');

import Routing from 'fos-routing';

Routing.setData(routes);



import 'codemirror/mode/sql/sql'
import CodeMirror from 'codemirror/lib/codemirror'
import {isEmpty} from "codemirror/src/util/misc";

const textarea = document.getElementById('request')
const editor = CodeMirror.fromTextArea(textarea, {
    mode: 'text/x-sql',
    lineNumbers: true,
    indentWithTabs: true,
    smartIndent: true,
    matchBrackets: true,
    autofocus: true,
})
editor.setOption('theme', 'material')


let sousSujet = getSubSbjet();
let question = getQuestion();


$("#exercice").change(function (e) {
    sousSujet = getSubSbjet()
    question = getQuestion()
})


function getSubSbjet() {
    return $("#exercice option:selected").parent().attr('label');
}

function getQuestion() {
    return $("#exercice option:selected").val();
}


let db = document.getElementById('valideRequest').getAttribute('database')
let sujet = document.getElementById('valideRequest').getAttribute('sujet')
$("#valideRequest").click(function (e) {
    e.preventDefault();
    let rq = editor.getValue()
    $.ajax({
            url: Routing.generate('requete'),
            type: 'GET',
            data: {
                'requete': rq,
                'database': db,
                'sujet': sujet,
                'sousSujet' : sousSujet
            },
            datatype: 'json',
            success: function (data) {
                $('#responses').empty();
                let reponse = document.getElementById('responses');
                console.log(data);
                console.log("test " + question)
                if (Array.isArray(data) === true && isEmpty(data)===false && sousSujet === "Requête") {
                    let table = document.createElement('table');
                    table.setAttribute('class', 'table shadow')
                    let thead = document.createElement('thead');
                    thead.setAttribute('class', "thead-dark")
                    let tr = document.createElement('tr');
                    Object.entries(data[0]).forEach(function ([key, value]) {
                        let th = document.createElement('th');
                        th.innerText = key.toString();
                        tr.append(th);
                        thead.append(tr)
                    })
                    table.append(thead)

                    data.forEach(function (x) {
                        let tbody = document.createElement('tbody');
                        let tr = document.createElement('tr');
                        Object.entries(x).forEach(function ([key, value]) {
                            let td = document.createElement('td');
                            td.innerText = value.toString();
                            tr.append(td);
                            tbody.append(tr)
                        })
                        table.append(tbody)
                    })
                    reponse.append(table)
                }
                else {
                    if (data[2] === null) {
                        reponse.append("Requête validée")
                    }
                    else {
                        reponse.append(data[2])
                    }
                }
            }
        }
    )
})

$("#supression").click(function(e){
    e.preventDefault();
    let resultat = confirm('Voulez vous vraiment supprimer votre base de données ?')
    if (resultat === true) {
        $.ajax({
            url : Routing.generate('supression'),
            type : 'GET',
            data : {
                'database' : db,
            },
            datatype : 'json',
            success : function(data){
                alert('Votre base de données a bien était supprimée')
            }
        })
    }
})

$("#voirReponse").click(function(e){
    e.preventDefault();
    let resultat = confirm('Voulez vous vraiment voir la réponse ?')
    if (resultat === true) {
        $.ajax({
            url: Routing.generate('solution'),
            type: 'GET',
            data: {
                'sujet': sujet,
                'database': db,
                'sousSujet' : sousSujet,
                'question' : question
            },
            datatype: 'json',
            success: function (data) {
                $('#requested').empty();
                let reponseAttendu = document.getElementById('requested' );
                if (Array.isArray(data) === true && isEmpty(data) ===false && sousSujet === "Requête") {
                    let table = document.createElement('table')
                    table.setAttribute('class', 'table shadow')
                    let thead = document.createElement('thead');
                    thead.setAttribute('class', "thead-dark")
                    let tr = document.createElement('tr');
                    Object.entries(data[0]).forEach(function ([key, value]) {
                        let th = document.createElement('th');
                        th.innerText = key.toString();
                        tr.append(th);
                        thead.append(tr)
                    })
                    table.append(thead)

                    data.forEach(function (x) {
                        let tbody = document.createElement('tbody');
                        let tr = document.createElement('tr');
                        Object.entries(x).forEach(function ([key, value]) {
                            let td = document.createElement('td');
                            td.innerText = value.toString();
                            tr.append(td);
                            tbody.append(tr)
                        })
                        table.append(tbody)
                    })

                    reponseAttendu.append(table)
                }
                else {
                    reponseAttendu.append(data)
                }

            }
        })
    }
})

$("#export-button").click(function(e){
        e.preventDefault()

    e.preventDefault();
    let resultat = confirm('Voulez vous vraiment exporter votre base de données ?')
    if (resultat === true) {
        $.ajax({
            url: Routing.generate('training_export'),
            type: 'GET',
            datatype: 'json',
            success: function (data) {
                console.log(data)
            },
            error: function (err) {
                console.error(err)
            }
        })
    }
})
