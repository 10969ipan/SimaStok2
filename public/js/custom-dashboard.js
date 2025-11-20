function initResponsiveTable() {
  if ($(window).width() < 768) {
    if (!$('.activity-table').parent().hasClass('table-responsive')) {
      $('.activity-table').wrap('<div class="table-responsive"></div>');
    }
  }
}