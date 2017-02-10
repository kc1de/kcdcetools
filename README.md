# kcdcetools

##Algemein
Kcdcetools sind ein Tool um Dynamic Content Elements (DCE) von einer TYPO3 Instanz in eine andere zu kopieren. 
DCE ist eine TYPO3 Extension die es einem erlaubt eigene Content-Elemente zu erstellen. 
Dazu werden die benötigten Felder für das Backend definiert und ein Fluid Template für die Frontendausgabe definiert. 
Im Moment gibt es bei der Extension noch keine Exportmöglichkeit um bereits erstellte DCE zu exportieren 
und in einer anderen TYPO3 Instanz zu importieren. 

Dieses Tool kopiert nun auf Datenbankebene alle benötigten Datenbankeinträge für ein ausgewähltes DCE 
und fügt diese in eine Zieldatenbank ein. Beim Kopieren werden die Primär- und Fremdschlüssel der kopierten Datensätze aktualisiert.

Das Tool ist sehr einfach gehalten. Es wurde weder Wert auf Design gelegt, noch auf Fehlerbehandlung. 
Die Benutzung geschieht auf eigene Gefahr. Bitte nur auf einem Test/Staging/Entwicklungssystem ausführen.
Ebenso bitte von der Datenbank vorher ein Backup machen, für den Fall dass etwas schief gehen sollte. 

Link zu der DCE Seite in der TYPO3 Extension Library: https://typo3.org/extensions/repository/view/dce  

Link zum Code der DCE Extension auf Bitbucket: https://bitbucket.org/ArminVieweg/dce/overview

Link zur Bugtrackingseite der DCE Extension: https://forge.typo3.org/projects/extension-dce/wiki/index


## Installation
Alle Dateien müssen in ein Verzeichnis auf dem Webserver kopiert werden. Die Startseite des Tools ist die Datei index.php. 
Sollte der Server vom Internet aus zu erreichen sein, muss das Verzeichnis noch zusätzlich abgesichert werden  (.htaccess).

ACHTUNG: Die Credentials für die Datenbankverbindung sind in der Datei settings.php anzugeben.
Bitte dazu vorher die Datei **settings.template.php in settings.php umbenennen**. 

## Screeenshots

1. Auswahl der Quell- und Zieldatenbank
![DB Auswahl](/doku/img/s1.JPG)
2. Auswahl des zu kopierenden DCE
![DCE Auswahl](/doku/img/s2.JPG)
3. Kontrolle des ausgewählten DCE
![Kontrollseite](/doku/img/s3.JPG)
4. Ergebnisseite des Kopiervorgangs
![Ergebnisseite](/doku/img/s4.JPG)
