function swap_marshrut() {
    var finish_street = $('#finish_street').val();
    var start_street = $('#start_street').val();
    var finish_home = $('#finish_home').val();
    var start_home = $('#start_home').val();
    var finish_entrance = $('#finish_entrance').val();
    var start_entrance = $('#start_entrance').val();
    $('#finish_street').val(start_street);
    $('#start_street').val(finish_street);
    $('#finish_home').val(start_home);
    $('#start_home').val(finish_home);
    $('#finish_entrance').val(start_entrance);
    $('#start_entrance').val(finish_entrance);
}