function loadAdmin() {
    var role_id = document.getElementById('role_id').value;

    $.ajax({
      url: `http://localhost/shop/authenticate/getPermissions?role_id=${role_id}`,
      type: "POST",
      data: {
        role_id: role_id,
      },
      dataType: "json",
      success: function (permissionData) {
        var taskNamesUser = [];
        for (var i = 0; i < permissionData.listPermission.length; i++) {
          taskNamesUser.push(permissionData.listPermission[i].task_name);
        }
        console.log(taskNamesUser)
        loadPermissionsFromDatabase(taskNamesUser);
      },
      error: function (error) {
        console.error("Lỗi khi lấy danh sách chức năng:", error);
        alert("An error occurred while fetching permissions.");
      },
    });
}


function loadPermissionsFromDatabase(taskNamesUser) {
    $.ajax({
      url: "http://localhost/shop/authenticate/getAllPermissions",
      type: "GET",
      dataType: "json",
      success: function (data) {
        // Sau khi nhận được dữ liệu, cập nhật navigationPermissions
        if (data) {
          var allTaskNames = [];
          data.listPermission.forEach(function(item) {
            allTaskNames.push(item.task_name);
          });
          loadNavigationBasedOnPermissions(taskNamesUser, allTaskNames);
        }
      },
      error: function (error) {
        console.error("Lỗi khi lấy danh sách chức năng từ cơ sở dữ liệu:", error);
        alert("An error occurred while fetching permissions.");
      },
    });
  }
  function loadNavigationBasedOnPermissions(taskNamesUser, allTaskNames) {
    // Lấy thẻ nav
    var sidebarNav = document.querySelector(".sidebar-nav");
  
    // Xóa nội dung navigation hiện tại
    sidebarNav.innerHTML = "";
  
    // Duyệt qua danh sách tất cả các tên nhiệm vụ
    allTaskNames.forEach(function(taskName) {
        // Kiểm tra xem tên nhiệm vụ có trong danh sách của người dùng không
        if (taskNamesUser.includes(taskName)) {
            // Nếu có, thêm mục navigation tương ứng
            var navItem = document.createElement("li");
            navItem.classList.add("sidebar-item");
            var navLink = document.createElement("a");
            navLink.classList.add("sidebar-link");
            // navLink.href = getLinkByNavItemText(taskName); // Bạn cần cung cấp hàm này để lấy đường link tương ứng với nhiệm vụ
            // navLink.setAttribute("aria-expanded", "false");
            // // Thêm icon nếu cần
            // var icon = getIconByNavItemText(taskName); // Hàm này cần được thay thế bằng hàm thực sự để lấy icon
            if (1>0) {
                navLink.innerHTML = `
                  <span>
                    <i class="ti ti-layout-dashboard"></i>
                  </span>
                  <span class="hide-menu">${taskName}</span>
                `;
            } else {
                navLink.textContent = taskName;
            }
            navItem.appendChild(navLink);
            sidebarNav.appendChild(navItem);
        }
    });
  }
  

loadAdmin()