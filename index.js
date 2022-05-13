var app = angular.module('myApp', []);
app.controller('raceCtrl', function($scope, $http) {
  $http.get("https://hedgerpro.co.uk/api/rpc/remote/b4y.php?action=getRaceRunners&marketId=1.199021059").then(function (response) {
      $scope.myData = response.data.runners;
  });
});