
function PrintReport(DivID) {
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,width=1200, height=700, left=100, top=25";
   var content_vlue = document.getElementById(DivID).innerHTML;
   var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
   docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head><title>Print Report</title>');
   docprint.document.write('<style type="text/css">body{ margin:0px;');
   docprint.document.write('font-family:Helvetica Neue",Helvetica, Arial,sans-serif, khmer os battambang; color:#000;border-collapse: collapse; padding-left: 3px; padding-right: 3px;');   docprint.document.write('font-family:Helvetica Neue",Helvetica,Arial,sans-serif, khmer os battambang; font-size:14px;border-spacing: 0; border-collapse: collapse;padding-left: 3px; padding-right: 3px;}');
   docprint.document.write('a{color:#000;text-decoration:none;} tr>th, tr>td{padding-left: 5px; padding-right: 5px;padding-top: 3px; padding-bottom: 1px;}</style>');
   docprint.document.write('</head><body onLoad="self.print()"><center>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}