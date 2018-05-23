

function handleKeyPress(e){
  startSearch(e, searchUser);
}

function startSearch(e, methodName) {
  var key = e.keyCode || e.which;
  if (key == 13){
      methodName(e.target.value);
  }
}

function searchUser(searchString) {
  var url = window.location.href;
  var newUrl = new URL(url).pathname;
  queryString = makeSearchingString(searchString);

  redirectForSearchingSorting(queryString, newUrl);
}

function redirectForSearchingSorting(queryParameters, redirectTo) {
  hostname = window.location.origin;
  url = hostname + redirectTo  + queryParameters;
  window.location.href = url;
}

function makeSearchingString(searchString)
{
  var searchParam = get_query();
  var string = "?";
  if (searchString) {
    string += "search=" + searchString + "&";
  }
  // if (searchParam.filter_status) {
  //   string += "filter_status=" + searchParam.filter_status + "&";
  // }
  if (searchParam.perPage) {
    string += "perPage=" + searchParam.perPage + "&";
  }
  if (searchParam.orderBy) {
    string += "order=" + searchParam.order + "&" + "orderBy=" + searchParam.orderBy;
  }
  return string;
}

function get_query(){
  var url = location.search;
  var qs = url.substring(url.indexOf('?') + 1).split('&');
  for(var i = 0, result = {}; i < qs.length; i++){
    qs[i] = qs[i].split('=');
    result[qs[i][0]] = decodeURIComponent(qs[i][1]);
  }
  return result;
}

$("#perPageTickets").change(function(e) {
  queryString = getItemsPerPage(e.target.value);
  var url = window.location.href;
  var newUrl = new URL(url).pathname;
  redirectForSearchingSorting(queryString, newUrl);
});

function getItemsPerPage(itemPerPage) {
  var searchParam = get_query();
  var string = "?";
  if (searchParam.page) {
    string += "page=" + searchParam.page + "&";
  }
  if (searchParam.search) {
    string += "search=" + searchParam.search + "&";
  }
  // if (searchParam.filter_status) {
  //   string += "filter_status=" + searchParam.filter_status + "&";
  // }
  if (itemPerPage) {
    string += "perPage=" + itemPerPage + "&";
  }
  if (searchParam.order) {
    string += "order=" + searchParam.order + "&" + "orderBy=" + searchParam.orderBy ;
  }
  return string;
}

// function handleKeyPress(e) {

//   var key = e.keyCode || e.which;
//   var queryString = '';
//   if (key == 13) {

//     var searchterm = e.target.value;
//     var searchParam = get_query();
//     queryString = statusFilterItems('',searchterm);
//     if(searchParam.status) {
//       queryString = statusFilterItems(searchParam.status,searchterm);
//     }
//     var url = window.location.href;
//     var newUrl = new URL(url).pathname;
//     redirectForSearchingSorting(queryString, newUrl);
//   }
// }

// function statusFilterItems(filterByStatus,searchterm) {

//   var searchParam = get_query();

//   var string = "?";
//   if (filterByStatus) {
//     string += "status=" + filterByStatus + "&";
//   }
//   if(searchterm) {
//      string += "searchterm=" + searchterm + "&";
//   }
//   return string;
// }

// //will redirect to perticuler page with query parameters.
// function redirectForSearchingSorting(queryParameters, redirectTo) {
//   hostname = window.location.origin;
//   url = hostname + redirectTo  + queryParameters;
//   window.location.href = url;
// }

// function get_query(){
//   var url = location.search;
//   var qs = url.substring(url.indexOf('?') + 1).split('&');
//   for(var i = 0, result = {}; i < qs.length; i++){
//     qs[i] = qs[i].split('=');
//     result[qs[i][0]] = decodeURIComponent(qs[i][1]);
//   }
//   return result;
// }
