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
            },
            datatype: 'json',
            success: function (data) {
                $('#responses').empty();
                let reponse = document.getElementById('responses');
                console.log(data);
                console.log("test " + question)
                if (Array.isArray(data) === true && isEmpty(data) === false) {
                    let thead = document.createElement('thead');
                    thead.setAttribute('class', "thead-dark")
                    let tr = document.createElement('tr');
                    Object.entries(data[0]).forEach(function ([key, value]) {
                        let th = document.createElement('th');
                        th.innerText = key.toString();
                        tr.append(th);
                        thead.append(tr)
                    })
                    reponse.append(thead)

                    data.forEach(function (x) {
                        let tbody = document.createElement('tbody');
                        let tr = document.createElement('tr');
                        Object.entries(x).forEach(function ([key, value]) {
                            let td = document.createElement('td');
                            td.innerText = value.toString();
                            tr.append(td);
                            tbody.append(tr)
                        })
                        reponse.append(tbody)
                    })
                }

            }
        }
    )
    $.ajax({
        url: Routing.generate('solution'),
        type: 'GET',
        data: {
            'sujet': sujet,
            'database': db,
            'sousSujet': sousSujet,
            'question': question
        },
        datatype: 'json',
        success: function (data) {
            $('#requested').empty();
            let reponseAttendu = document.getElementById('requested');
            console.log(data);
            console.log("test " + question)
            if (Array.isArray(data) === true && isEmpty(data) === false) {

                let thead = document.createElement('thead');
                thead.setAttribute('class', "thead-dark")
                let tr = document.createElement('tr');
                Object.entries(data[0]).forEach(function ([key, value]) {
                    let th = document.createElement('th');
                    th.innerText = key.toString();
                    tr.append(th);
                    thead.append(tr)
                })
                reponseAttendu.append(thead)

                data.forEach(function (x) {
                    let tbody = document.createElement('tbody');
                    let tr = document.createElement('tr');
                    Object.entries(x).forEach(function ([key, value]) {
                        let td = document.createElement('td');
                        td.innerText = value.toString();
                        tr.append(td);
                        tbody.append(tr)
                    })
                    reponseAttendu.append(tbody)
                })
            }
        }
    })
})

document
    .getElementById('export-button')
    .addEventListener('click', (e) => {
        e.preventDefault()
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
    })
