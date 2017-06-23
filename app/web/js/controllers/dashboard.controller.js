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
		$scope.tableHeaders = [
			{title: 'ELECTION CENTER', field: 'qendra_id'},
			{title: 'POTENTIAL VOTES', field: 'potential'},
			{title: 'POTENTIAL VOTES (DONE)', field: 'potential_done'},
			{title: 'CASUAL VOTES', field: 'casual'},
			{title: 'CASUAL VOTES (DONE)', field: 'casual_done'},
			{title: 'TOTAL', field: 'total'}
		];
		$scope.typeOfViews = ['Table', 'Billboard', 'Graphs'];
		$scope.selectedView = 'Table';
		$scope.centers = [];
		$scope.selectedCenter = "All";
		$scope.centerData = [];
		$scope.orderField = 'total';
		$scope.order = true;
		$scope.colours = ['#e43838', '#22a722', '#fd6a0a', '#0747e7'];
		$scope.labels = ["POTENTIAL VOTES", "POTENTIAL VOTES (DONE)", "CASUAL VOTES", "CASUAL VOTES (DONE)"];
 
		$scope.orderTableContent = function(header) {
			if(header.field == $scope.orderField) $scope.order = !$scope.order;
			else {
				$scope.orderField = header.field;
				$scope.order = true;
			}
		}

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

			$scope.centerData = _.map(response.data, function(center) {
				center.pieData = [center.potential, center.potential_done, center.casual, center.casual_done];
				return center;
			});
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