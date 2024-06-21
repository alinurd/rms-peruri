$("#add_sasaran").click(function () {
    var row = $("#tbl_sasaran > tbody");
    // row.append('<tr><td class="text-center">'+edit+'</td><td>'+sasaran+'</td><td>'+strategi+'</td><td>'+kebijakan+'</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"<i class="fa fa-cut"></span></td></tr>');
    row.append('<tr><td class="text-center">' + edit + '</td><td>' + sasaran + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>');
});
