<header>
    <h1>Download KIN Event Keyer {{ page.version }}</h1>
    <p id='release-date'>Release date: {{ page.date | date: "%B %-d, %Y" }}</p>
</header>
<div id='main-content'>
    <p>By downloading and using this software, you agree to the <a href='/kin-event-keyer/license'>License Agreement</a>.</p>
    <form action='?' method='post'>
        <label>License Key: </label>
        <input type='text' name='key'>
        <br>
        <input class='button' type='submit' value='Download'>
        <p id='error_message'>$error</p>
    </form>
    <h2>Installation</h2>
    <p>KIN Event Keyer does not require any installation but is targeted to run on Java SE 6 which can be downloaded 
        <a href='https://www.oracle.com/technetwork/java/javase/downloads/java-archive-downloads-javase6-419409.html'>here</a>.
    </p>
</div><!--
--><div class='side-panel container'>
    <h2 class='side-panel-header'>Related Links</h2>
    <ul>
        <li>
            <a class='link-item' href='https://github.com/Frostphyr/KIN-Event-Keyer'>
                <img class='small-logo line-item' src='/images/GitHub-mark-light.svg' alt='GitHub'/>
                <span class='a-text line-item'> GitHub</span>
            </a>
        </li>
        <li><a href='/kin-event-keyer/releases/{{ page.version }}'>Release Notes</a></li>
        <li><a href='/kin-event-keyer/releases'>All Releases</a></li>
    </ul>
</div>