<script language="JavaScript" type="text/javascript">
<!-- // selcbox by Elf Qrin r20sep2016 fr24nov2002
function selItm(t) {
var eb=1; var tw=document.console.length-1;
var itmn="document.console.elements";
switch (t) {
case 1:
for (var i=eb;i<=tw;i++) {var ir=eval(itmn+"["+i+"]"); if (ir.type=="checkbox") {ir.checked=true;}}
break;
case 2:
for (var i=eb;i<=tw;i++) {var ir=eval(itmn+"["+i+"]"); if (ir.type=="checkbox") {ir.checked=false;}}
break;
case 3:
for (var i=eb;i<=tw;i++) {
var ir=eval(itmn+"["+i+"]");
if (ir.type=="checkbox" && ir.checked) {ir.checked=false;} else {ir.checked=true;}
}
break;
}
}

function drawSelItmButtons() {
document.writeln('<? echo "Select"; ?>:');
document.writeln('<input type="button" class="submitinput" value="<? echo "All"; ?>" onClick="selItm(1);">');
document.writeln('<input type="button" class="submitinput" value="<? echo "None"; ?>" onClick="selItm(2);">');
document.writeln('<input type="button" class="submitinput" value="<? echo "Toggle"; ?>" onClick="selItm(3);">');
}
// -->
</script>
