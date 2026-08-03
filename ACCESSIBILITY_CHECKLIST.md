Accessibility & responsive checklist

- Keyboard navigable pages (tab order, focus states)
- Images have descriptive `alt` attributes
- Sufficient color contrast (WCAG AA)
- Form labels associated with inputs
- Semantic HTML structure (headings, landmarks)
- Responsive layout for mobile, tablet, desktop
- No reliance on color alone to convey information
- ARIA attributes used only when necessary
- Test with screen reader (NVDA or VoiceOver)
- Run automated audits (Lighthouse, axe)

Testing steps
1. Run Lighthouse accessibility audit in Chrome for main pages (dashboard, admin users, teacher grades, student records).
2. Run axe-core automated checks during CI (npm package `axe-core` or `axe-playwright`).
3. Manual keyboard and screen reader tests.
