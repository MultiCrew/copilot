@extends('layouts.base')

@section('title', 'About Us')

@section('content')

<h2>Our History</h2>

<p style="line-height: 1.5; font-size: 1.2rem;">
    MultiCrew was an idea coined by two high school students in late 2016 as a brand name to encompass some social media
    groups promoting shared cockpit flying. Starting out as a Facebook page, several iterations of a static website
    containing information and advice on shared cockpit were developed. The development of the MultiCrew Academy brought
    some basic community-organised training through shared cockpit, and we trialed the first version of our Copilot
    software.
</p>
<p style="line-height: 1.5; font-size: 1.2rem;">
    We took a break in 2019, and in 2020 started development again, from scratch, this time fully open source. We are
    now working towards a public release of our Copilot software, which is currently in beta testing!
</p>

<hr class="my-5">

<h2>Staff Team</h2>

<div class="row">
    <div class="col-md-6 mb-3 text-center">
        <!--<img class="rounded-circle my-4" src="https://via.placeholder.com/200">-->
        <h5>Harry Cameron</h5>
        <p class="mb-0 text-left">
            Harry, the first half of the development team, brings the real-world experience, being in the aviation
            industry himself. Harry, the founder of MultiCrew, has been actively involved in VATSIM UK and other
            similar-sized flight sim projects.<br>
            Harry's main development tasks include most of the backend systems and well as third-party intergations.
        </p>
    </div>

    <div class="col-md-6 text-center">
        <!--<img class="rounded-circle my-4" src="https://via.placeholder.com/200">-->
        <h5>Calum Shepherd</h5>
        <p class="mb-0 text-left">
            An Engineering student, Calum is the other half of the development team at MultiCrew. A passionate flight
            simmer, as well as VATSIM controller, his main motivation is to get more involvement in shared cockpit, as
            he feels it is <em>the</em> most immersive feature of any aircraft addon.<br>
            Calum does most of the frontend work at MultiCrew, as well as some backend too.
        </p>
    </div>
</div>
<hr class="my-5">

<h2>Frequenty Asked Questions</h2>

<div class="accordion" id="faqAccordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapseOne">
                    Can I do shared cockpit with MultiCrew?
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" data-parent="#faqAccordion">
            <div class="card-body">
                No, MultiCrew is an organisation which provides tools to help you fly shared cockpit, but does not
                provide shared cockpit capabilities to any simulator or aircraft itself - that is down to aircraft
                developers or some third party (.e.g SmartCopilot for X-Plane).
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseTwo">
                    If I can't do shared cockpit with this, then what's the point?
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse" data-parent="#faqAccordion">
            <div class="card-body">
                Our main project, Copilot, is a tool to help you organise and dispatch shared cockpit flights. We will
                help you find a copilot for your sim and aircraft with similar other addons and preferences. The tool
                also helps you manage your flight planning, and we have a Discord server you can use for VoIP comms.
            </div>
        </div>
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseThree">
                    What does it cost?
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" data-parent="#faqAccordion">
            <div class="card-body">
                Nothing! MultiCrew will always strive to provide its service basic services for free. Of course, we
                still have operating costs, so donations are always appreciated :)
            </div>
        </div>
        <div class="card-header" id="headingFour">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseFour">
                    How do I use Copilot?
                </button>
            </h2>
        </div>
        <div id="collapseFour" class="collapse" data-parent="#faqAccordion">
            <div class="card-body">
                At the moment, Copilot is in <strong>closed beta</strong> which means that it is only accessible by a
                select group of people - our "beta testers" - to check over the software, how easy it is to use and how
                good it looks. Once we're all happy with it, we will release it to the public (you!).<br>
                If you're interested in becoming a part of the beta team, simply create an account and apply to join
                from there.
            </div>
        </div>
        <div class="card-header" id="headingFive">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseFive">
                    Which simulators/aircraft are supported?
                </button>
            </h2>
        </div>
        <div id="collapseFive" class="collapse" data-parent="#faqAccordion">
            <div class="card-body">
                All of them! Our software is all web-based, independent of any simulator or aircraft, so you can use it
                with any software you like. Of course, we have a list of commonly used simulators and aircraft which you
                can select, but the community can contribute to that as well!
            </div>
        </div>
        <div class="card-header" id="headingSix">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseSix">
                    I want to help! How to I join?
                </button>
            </h2>
        </div>
        <div id="collapseSix" class="collapse" data-parent="#faqAccordion">
            <div class="card-body">
                If you're a software developer, you can head to our <a href="https://github.com/MultiCrew/">GitHub</a>
                (everything is open source!) and fork the repository right away! If you're interested in helping in any
                context, join our <a href="https://discord.gg/3jHRAkE">Discord server</a> and speak to a staff member.
            </div>
        </div>
    </div>
</div>

@endsection
