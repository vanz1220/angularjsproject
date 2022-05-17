

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
            //console.log("DATE: ",$scope.finaldate);

            $http.get("https://hedgerpro.co.uk/api/rpc/remote/b4y.php?action=getRaces&date="+ $scope.finaldate).then(function (response) {
                
                $scope.myData1 = response.data.races;
                //console.log("Races: ",$scope.myData1);
                if($scope.myData1 != null){
                angular.forEach( $scope.myData1, function(b4y_datetime) {
                    //console.log("DATETIME: ", b4y_datetime.date_time);
                  });
                  angular.forEach( $scope.myData1, function(b4y_venue) {
                    //console.log("VENUE: ", b4y_venue.venue);
                  });
                  angular.forEach( $scope.myData1, function(b4y_marketid) {
                    //console.log("MARKETID: ", b4y_marketid.marketId);
                  });
                }
            })
        }

         $scope.getdetails = function () {
          $scope.xmarketid = $scope.x.marketId;
          

          $http.get('https://hedgerpro.co.uk/api/rpc/remote/b4y.php?action=getRaceRunners&marketId='+ $scope.xmarketid).then(function(response1){
                $scope.runnersList = response1.data.runners;
                //console.log("Runners: ",$scope.runnersList);
                
            })
        }
    })