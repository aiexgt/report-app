<?php

function getComponentStyle(){

    return '
        <style>
            @page {
                size: letter;
                margin: 0.5in;
            }
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }
            .container {
                display: table;
                width: 100%;
                border-collapse: collapse;
            }
            .row {
                display: table-row;
            }
            .cell {
                display: table-cell;
                padding: 2px;
            }
            .cell-table {
                display: table-cell;
                border: 1px solid gray;
            }
            .cb{
                border: 2px solid #000;
            }
            table{
                width:100%;
                font-size:11px;
                border-collapse: collapse;
                border: 2px solid #000;
            }
            table th{
                background-color: #000;
                color: #fff;
                border: 2px solid #000;
            }
            table td{
                border: 1px solid #000;
            }
            .w-10{
                width:10%;
            }
            .w-20{
                width:20%;
            }
            .w-25{
                width:25%;
            }
            .w-30{
                width:30%;
            }
            .w-40{
                width:40%;
            }
            .w-50{
                width:50%;
            }
            .w-60{
                width:60%;
            }
            .w-70{
                width:70%;
            }
            .w-80{
                width:80%;
            }
            .w-auto{
                width:auto;
            }
            .bg-secondary{
                background-color:#A3A3A3;
            }
            .text-center{
                text-align: center;
            }
            .text-start{
                text-align: left;
            }
            .text-end{
                text-align: right;
            }
            .fw-11{
                font-size:11px;
            }
            .evidencia{
                max-height:22cm;
                max-width:17cm;
                height:auto;
                width:auto;
            }
            .fw{
                font-weight:bold;
            }
        </style>
    ';

}