<script type="text/javascript">
    var macAddress = "";
    var ipAddress = "";
    var computerName = "";
    var wmi = GetObject("winmgmts:{impersonationLevel=impersonate}");
    e = new Enumerator(wmi.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration WHERE IPEnabled = True"));
    for(; !e.atEnd(); e.moveNext()) {
        var s = e.item();
        macAddress = s.MACAddress;
        ipAddress = s.IPAddress(0);
        computerName = s.DNSHostName;
    }
</script>

<input type="text" id="txtMACAdress" />
<input type="text" id="txtIPAdress" />
<input type="text" id="txtComputerName" />

<script type="text/javascript">
    document.getElementById("txtMACAdress").value = unescape(macAddress);
    document.getElementById("txtIPAdress").value = unescape(ipAddress);
    document.getElementById("txtComputerName").value = unescape(computerName);
</script>