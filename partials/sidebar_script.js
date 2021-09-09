function showmenu(elem) {
    // Clear any currently open menu
    var openMenu = document.getElementById("activeMenu");
    if (openMenu) {
      openMenu.removeAttribute("id");
      // Stop if we're just closing the current menu
      if (openMenu === elem) {
        return;
      }
    }
  
    // Only apply it if the element actually has LI child nodes.
    // OPTIONAL: Will still work without if statement.
    if (elem.getElementsByTagName("li").length > 0) {
      elem.setAttribute("id", "activeMenu");
    }
  }