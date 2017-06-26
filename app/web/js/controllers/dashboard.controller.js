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
		$scope.progressTableHeaders = [
			{title: 'ELECTION CENTER', field: 'qendra_id'},
			{title: 'POTENTIAL VOTES (DONE)', field: 'potential_done'},
			{title: 'CASUAL VOTES (DONE)', field: 'casual_done'},
			{title: 'POTENTIAL + CASUAL', field: 'receivedVotes'},
			{title: 'TOTAL', field: 'total'}
		];
		$scope.progressTableData = {
			center: "All",
			potential: 0,
			casual: 0,
			potentialCasual: 0,
			total: 0
		};
		$scope.typeOfViews = ['Data Table', 'Billboard', 'Graphs', 'Progress Table'];
		$scope.selectedView = 'Data Table';
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

		$scope.checkView = function() {
			if($scope.selectedView == 'Progress Table') $scope.selectedCenter = 'All';
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

			_.each(response.data, function(center) {
				$scope.progressTableData.potential += center.potential_done;
				$scope.progressTableData.casual += center.casual_done;
				$scope.progressTableData.potentialCasual += center.potential_done + center.casual_done;
				$scope.progressTableData.total += center.total;
			})
		});

		$scope.exportCSV = function() {
			var downloadedData = angular.copy($scope.centerData);

			downloadedData = _.map(downloadedData, function(data) {
				return {
					QENDRA_ID: data.qendra_id,
					POTENTIAL_VOTES: data.potential,
					POTENTIAL_VOTES_DONE: data.potential_done,
					CASUAL_VOTES: data.casual,
					CASUAL_VOTES_DONE: data.casual_done,
					TOTAL: data.total
				}
			})

			var csv = agnes.jsonToCsv(downloadedData);
			var csv = "data:text/csv;charset=utf-8," + csv;
			var encodedUri = encodeURI(csv);

			var link = document.createElement("a");
			link.setAttribute("href", encodedUri);
			link.setAttribute("download", "statistics_" + moment().format('YYYY_MM_DD_HH_mm') + ".csv");
			document.body.appendChild(link); // Required for FF

			link.click();
		}
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