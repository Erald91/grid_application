(function() {
	angular.module('gridApp')
		   .controller('DashboardCtrl', dashboardCtrl)
		   .filter('FilterCenters', filterCenters);

	dashboardCtrl.$inject = ['$scope', '$http'];

	function dashboardCtrl($scope, $http) {
		$scope.constants = {
			URLs: {
				GET_CENTERS_DATA: '/site/centers-data'
			}
		}
		$scope.confs = {
			get: {
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			}
		}
		$scope.centers = [];
		$scope.selectedCenter = "All";
		$scope.centerData = [];

		$scope.retrieveListOfCenters = function(callback) {
			$http
			.get($scope.constants.URLs.GET_CENTERS_DATA, $scope.confs.get)
			.then(function({data, status}) {
				callback(data, status)
			}, function({data, status}) {
				console.error(data, status)
			})
		}

		$scope.retrieveListOfCenters(function(response, status) {
			if(!response.success) {
				alert('Something went wrong!');
				console.error(response, status);
			}

			$scope.centers = _.map(response.data, function(center) {
				return center.qendra_id;
			});
			$scope.centers.unshift("All");

			$scope.centerData = response.data;
		});
	}

	function filterCenters() {
		return function(centersList, selectedCenter) {
			if(selectedCenter == "All") return centersList;
			return _.filter(centersList, function(center) {
				return center.qendra_id == selectedCenter;
			});
		}
	}
})();