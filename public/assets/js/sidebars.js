/* global bootstrap: false */


$(document).ready( function () {

  'use strict'
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl)
  });
  $('#rider-table').addClass('table-responsive table');
  $('#rider-table').css('width','100%');
  $('.sorting').css('width','');
  $('.paginate_button').css('background-color','#198754!important');
} );

// $.extend(true, DataTable.defaults, {

//   language: 
// });

