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
      
        $scope.myvalue = false;
        $scope.myvalue2 = false;

        $scope.getdatedetails = function () {
            $scope.myvalue = false;
            $scope.myvalue2 = false;

            $scope.finaldate = formatDate($scope.datedetails);
            //console.log("DATE: ",$scope.finaldate);

            $http.get("https://bet4you.co.uk/wp-content/plugins/b4y_ratings/api/models/DisplayRating.php?day="+ $scope.finaldate).then(function (response) {
                    
                    if(!Object.keys(response.data.races).length){
                        $scope.msg = "NO DATA AT THE MOMENT!!!";
                        //console.log("NO DATA AT THE MOMENT");
                        $scope.myvalue2 = true;
                        $scope.myvalue = false;
                        $scope.myData1 = [];
                    }else{
                        $scope.myData1 = response.data.races;
                        //console.log("Races: ",$scope.myData1);
                        $scope.myvalue2 = false;
                        $scope.myvalue = true;
                        $scope.msg = "";
                    }
            })
        }

         $scope.getdetails = function () {
                $scope.xmarketid = $scope.x.marketId;
                

                $http.get('https://bet4you.co.uk/wp-content/plugins/b4y_ratings/api/models/DisplayRunners.php?marketid='+ $scope.xmarketid).then(function(response1){
                $scope.runnersList = response1.data.ratings;
                
                angular.forEach($scope.runnersList, function (runnerId, key) {
                    runnerId = $scope.runnersList[key].id;
                    console.log("RUNNERS ID: ",runnerId);
                }); 
                
                $scope.groups = [{
                    "value": 100
                },
                {
                    "value": 90
        
                },
                {
                    "value": 80
        
                },
                {
                    "value": 70
        
                },
                {
                    "value": 60
        
                },
                {
                    "value": 50
        
                },
                {
                    "value": 40
        
                },
                {
                    "value": 30
        
                },
                {
                    "value": 20
        
                },
                {
                    "value": 10
        
                },
                {
                    "value": 0
        
                }];

                })
        }
        
        $scope.updateData = function(id, rate){  
            $http.get('https://bet4you.co.uk/wp-content/plugins/b4y_ratings/api/models/UpdateRating.php?selectionId='+ id +'&b4y_rating='+ rate).then(function(response1){
                
                console.log("SUCCESS", response1.data.message);
                
            })
       } 
    })

    