<?
include('site_header.php');
?>
<CENTER>
<?
echo '<P>';
echo '<H1>';
echo "<A HREF=\"".$edge_main_url."\">".$edge_project_name."</A><BR>";
echo '</H1>';
echo "<A HREF=\"".$edge_main_url."\">".$edge_main_url."</A><P>";
echo "Webmaster: ".$edge_webmaster_name."<BR>";
echo "<P>Copyright &copy; ".$edge_project_name;
?>

<P>

<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=3><TR><TD>
<A NAME="disclaimer"></A>
<FONT SIZE=+1><B>Disclaimer</B></FONT><P>
To the maximum extent permitted by law, the author disclaims all warranties regarding
this material, express or implied, including but not
limited to warranties of merchantability and fitness for a particular purpose and non-infringement.<BR>
The author makes no warranties, implied or otherwise, as to the usefulness of this material
or the correctness of the information it provides.<BR>
In no event shall the author be liable for direct, indirect, special, consequential, incidental, exemplary, punitive or any other kind of damages
caused by or arising out of the use or inability to use this material even if he is aware of the possibility of such damages or a known defect.<BR>
This material is provided "as is" and "as available", without any warranty, and if you use it you do it at your own risk, with no support.<BR>
The author makes no warranty the material will meet your requirements, or that its availability will be uninterrupted, or that it is timely, secure, or error free;
nor does the author make any warranty as to the results that may be obtained through the material or that defects will be corrected.<BR>
No advice or information, whether oral or written, which you obtain from the author or through the material or third parties shall create any warranty not expressly made herein.<BR>
By accessing or using this material, you are agreeing to these terms.
<P><BR>
<A NAME="copyright"></A>
<FONT SIZE=+1><B>Copyright</B></FONT><P>
<?
# You may choose one of the following licenses
echo 'The material contained in this website is copyrighted by the author. All rights reserved.';
# echo 'Except where otherwise noted, all the material provided by this website is licensed under a <a href="http://creativecommons.org/licenses/by-sa/2.5/" TARGET="_blank">Creative Commons Attribution Share Alike "by-sa/2.5" License</a>.';
# echo 'Except where otherwise noted, all the material provided by this website is licensed under a <a href="http://creativecommons.org/licenses/by-nc-sa/2.5/" TARGET="_blank">Creative Commons Attribution Non Commercial Share Alike "by-nc-sa/2.5" License</a>.';
# echo 'Except where otherwise noted, all the material provided by this website is licensed under a <a href="http://www.fsf.org/licensing/licenses/fdl.html" TARGET="_blank">GFDL (GNU Free Documentation License)</a>.'; # Text only: http://www.fsf.org/licensing/licenses/fdl.txt
?>
<p>
<P><BR>
<A NAME="thirdpcont"></A>
<FONT SIZE=+1><B>Third parts content</B></FONT><P>
The author doesn't make any preventive control over third part postings on the website (including but not limited to the web boards, web logs, and the advertising banners), but reserves the right to remove any posting.
<p>
<?
echo 'You hereby grant to '.edge_project_name.', a non-exclusive, perpetual, world-wide, royalty-free, irrevocable license, including with all rights to sublicense, in the copyright, database, and publicity rights of the Personal Information (within the scope of the <a href="#privacy">Privacy Policy</a>) and Content you provide, in any form of media now known or hereafter discovered or created.';
// echo '<BR>Users who voluntarily post their own material to this website, agree to adhere to the website\'s content license, unless they can choose another available license when posting their data.';
?>
<P><BR>
<A NAME="privacy"></A>
<FONT SIZE=+1><B>Privacy policy</B></FONT><P>
This Web site may request personal information that personally identifies you, and information that allows you to be personally contacted. Submission of this data is optional and may be a pseudo representation. Such information is not shared with any third parties.
<BR>
Any optionally submitted personal information is used for their implied purpose within the network - such as, but not limited to, the public-user whois services.
<BR>
This website contains links to other websites. The author is not responsible for the privacy policies or the content of such websites. 
<BR>
This website may use <I>cookies</I> to perform temporary data storage. They are not used to track users activities.
<P><BR>
<A NAME="warning"></A>
<FONT SIZE=+1><B>Warning</B></FONT><P>
You are expressely warned NOT to send unsolecited commercial mail, bulk mail, junk mail, chain letters (<I>"spam"</I>)
or to misuse in any other way the addresses you find inside the material.<BR>
<P><BR>
<A NAME="nowaiver"></A>
<FONT SIZE=+1><B>No waiver</B></FONT><P>
No delay or failure to take action under these notices will constitute a waiver by the author, unless expressly waived in writing by the same author.
<P><BR>
<A NAME="contacts"></A>
<FONT SIZE=+1><B>Contacts</B></FONT><P>
<?
echo '<a href="'.$edge_main_url.'contacts.php">'.'contacts'.'</a>';
?>
<!-- <P><BR>
<A NAME="notes"></A>
<FONT SIZE=+1><B>Notes</B></FONT><P>
 -->
</TD></TR></TABLE>

<P><BR>
<A NAME="dagger"></A>
<?
$dagger_url='http://labs.geody.com/dagger/';
echo "<H1>";
echo "<A HREF=\"".$dagger_url."\">Dagger</A><BR>";
echo "</H1>";
echo "<A HREF=\"".$dagger_url."\">".$dagger_url."</A><P>";
?>

<P>
<B>Dagger web engine is based on the <a href="http://edge.dev.box.sk/">Edge Engine</a></B><BR>
<B>Contains <A HREF="http://www.lumbroso.com/scripts/">FormMail</A> by Joseph Lumbroso<BR>
<B>Contains code from PHPRecommend by A. Gianotto</A><BR>
<B>Dagger "Elf with a dagger" logo was created by a contributor who prefers to remain anonymous</B>
<P>

<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=3><TR><TD>
<B>Dagger is released under <A HREF="http://www.fsf.org/licensing/licenses/gpl.txt" TARGET="_blank">GNU General Public License ("GPL")</A>.</B>
<PRE>
<? if (file_exists('docs/licenses/license_gpl.txt')) { include('docs/licenses/license_gpl.txt'); } ?>
</PRE>
</TD></TR></TABLE>

<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=3><TR><TD>
<P><BR>
<A NAME="special"></A>
<FONT SIZE=-1>
Issued on Saturday November, 18<SUP>th</SUP> 2006<BR>
These notices and disclaimer replace any previous one, and are subject to change without notice.
</TD></TR></TABLE>

</CENTER>

<? include('site_footer.php'); ?>
