<div class="container">
    <h1>Request</h1>
</div>




<div ng-controller="ROOMS">

    {{qasim}}

    {{root}}

    <div ng-repeat="room in rooms">
        <strong>{{room.name}}</strong> {{room.value}}
    </div>

</div>


<div class="container" style="overflow: hidden">
    <div ng-controller="CTRL" class="row">
        <div class="results c6" >
            <h2>Github Users</h2>
            <pre>{{github.users}}</pre>
        </div>
        <div class="results c6" >
            <h2>Github Repositories</h2>
            <pre>{{github.repositories}}</pre>
        </div>
    </div>
</div>


<script>
//     app.controller('HOTELS',function($scope) {
//         $scope.qasim= "qasim";
//
//         $(document).ready(function() {
//             var delay = 0;
//             var chek;
// //          e.preventDefault();
//             $.ajax({
//                 type: "GET",
//                 async:true,
//                 url: 'https://rest-hotels-api.herokuapp.com/v1/hotels',
//                 data: $(this).serialize(),
//                 success: function(response) {
//                     chek = JSON.stringify(response);
//                     setTimeout(function () {
//                         //    $scope.users = [{"id":1,"name":"Leanne Graham","username":"Bret"}];
//
//                     }, delay);
//                     console.log(chek);
//
//                 }
//
//             });
//
//
//             $scope.users = [
//                 {name:"USD",value:"1"},
//                 {name:"PKR",value:"105"},
//                 {name:"SAR",value:"3.7"},
//             ];
//
//         });
//
//
//
//     });

    app.controller('ROOMS', function($scope,$timeout, $http) {

        $scope.qasim= "qasim";
        $http({
            method : "GET",
            cache: true,
            url : "https://rest-hotels-api.herokuapp.com/v1/hotels"
        }).then(function mySuccess(response) {
            $scope.callAtTimeout = function() {
                $scope.rooms = response.data;
                console.log(response.data);
            }
            $timeout( function(){ $scope.callAtTimeout(); }, 3000);
        }, function myError(response) {
            $scope.rooms = response.statusText;
        });
    });

</script>






<script>
    app.controller('CTRL', function ($scope, $http, $q, $interval) {
        $scope.github = {};

        function getGithubData() {
            $scope.hideResults = true;
            $q.all({
                users: $http.get('https://rest-hotels-api.herokuapp.com/v1/hotels'),
                repos: $http.get('https://api.github.com/repositories')
            }).then(function(results) {
                $scope.github.users = JSON.stringify(results.users.data, null, 2);
                $scope.github.repositories = JSON.stringify(results.repos.data, null, 30);
                $scope.hideResults = false;
                // console.log($scope.github.users);
            });
        }

        $interval(getGithubData, 2000, 3);
    });

</script>