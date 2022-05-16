

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');

}
angular.module('app', [])
    .controller('ctrl', function($scope, $http){
      
         $scope.runnersList = [];

         $scope.getdatedetails = function () {
            $scope.finaldate = formatDate($scope.datedetails);
            //console.log("DAY: ",$scope.finaldate);

            $http.get("https://hedgerpro.co.uk/api/rpc/remote/b4y.php?action=getRaces&date="+ $scope.finaldate).then(function (response) {
                $scope.myData1 = response.data.races;
                //console.log("Races: ",$scope.myData1);
            })
        }

         $scope.getdetails = function () {
          $scope.xvenue = $scope.x.venue;
          $scope.xmarketid = $scope.x.marketId;

          $http.get('https://hedgerpro.co.uk/api/rpc/remote/b4y.php?action=getRaceRunners&marketId='+ $scope.xmarketid).then(function(data){
                $scope.runnersList = data.data.runners;
                //console.log("Runners: ",$scope.runnersList);
            })
        }
    })