<?php

namespace Board3r\MistralSdk\Enums;

enum ClassificationEnum: string
{
    /**
     * Material that explicitly depicts, describes, or promotes sexual activities, nudity, or sexual services.
     * This includes pornographic content, graphic descriptions of sexual acts, and solicitation for sexual purposes.
     * Educational or medical content about sexual health presented in a non-explicit, informational context is generally exempted.
     */
    case sexual = 'sexual';
    /**
     * Content that expresses prejudice, hostility, or advocates discrimination against individuals or groups based on protected characteristics such as race,
     * ethnicity, religion, gender, sexual orientation, or disability. This includes slurs, dehumanizing language,
     * calls for exclusion or harm targeted at specific groups, and persistent harassment or bullying of individuals based on these characteristics.
     */
    case hate_and_discrimination = 'HateAndDiscrimination';
    /**
     * Content that describes, glorifies, incites, or threatens physical violence against individuals or groups.
     * This includes graphic depictions of injury or death, explicit threats of harm, and instructions for carrying out violent acts.
     * This category covers both targeted threats and general promotion or glorification of violence.
     */
    case violence_and_threats = 'ViolenceAndThreats';
    /**
     * Content that promotes or provides instructions for illegal activities or extremely hazardous behaviors that pose a significant risk of physical harm,
     * death, or legal consequences. This includes guidance on creating weapons or explosives, encouragement of extreme risk-taking behaviors,
     * and promotion of non-violent crimes such as fraud, theft, or drug trafficking.
     */
    case dangerous_and_criminal_content = 'DangerousAndCriminalContent';
    /**
     * Content that promotes, instructs, plans, or encourages deliberate self-injury, suicide, eating disorders, or other self-destructive behaviors.
     * This includes detailed methods, glorification, statements of intent, dangerous challenges, and related slang terms
     */
    case selfharm = 'SelfHarm';
    /**
     * Content that contains or tries to elicit detailed or tailored medical advice.
     */
    case health = 'Health';
    /**
     * Content that contains or tries to elicit detailed or tailored financial advice.
     */
    case financial = 'Financial';
    /**
     * Content that contains or tries to elicit detailed or tailored legal advice.
     */
    case law = 'Law';
    /**
     * Content that requests, shares, or attempts to elicit personal identifying information such as full names,
     * addresses, phone numbers, social security numbers, or financial account details.
     */
    case pii = 'Pii';
}
