var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http) {
  $http.get("https://hedgerpro.co.uk/api/rpc/remote/b4y.php?action=getRaces&date=2022-05-13").then(function (response) {
      $scope.myData = response.data.races;
  });
});