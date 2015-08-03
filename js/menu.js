var menuApp = angular.module("menuApp", []);
menuApp.controller("menuController", function($scope) {
    $scope.menus = {};
    if(userName){
        $scope.role = '';
        $scope.typeMenu = 'fixed';
        $scope.menus.left = [
          {
              title: "Timer", 
              action: "/timer/index"
          },
          {
              title: "Reports", 
              action: "#", 
              menus: [
                  {
                      title: "Daily",
                      action: "/reports"
                  },
                  {
                      title: "Weekly",
                      action: "/reports/weekly"
                  },
                  {
                      title: "Monthly",
                      action: "/reports/monthly"
                  }
              ]
          },
          {
              title: "Projects", 
              action: "/timer/projects"
          },
          /* {
              title: "Team", 
              action: "/team", 
          }, */
          {
              title: "Settings", 
              action: "/timer/settings"
          }
        ];

        $scope.menus.right = [
            {
                title: userName, 
                action: "#",
                menus: [
                    {
                        title: "Profile",
                        action: "/profile"
                    },
                    {
                        title: "Log Out",
                        action: "/site/logout"
                    }
                ]
            }
        ];
    } else {
        $scope.role = 'role="navigation"';
        $scope.typeMenu = 'static';
        $scope.menus.left = [
            {
                title: "HOME", 
                action: "/site/index"
            },
            {
                title: "ABOUT", 
                action: "/site/about"
            },
            {
                title: "CONTACT", 
                action: "/site/contact"
            },
            {
                title: "SIGNUP & PRICING", 
                action: "/site/registration"
            }
        ];

        $scope.login = true;
    }
});